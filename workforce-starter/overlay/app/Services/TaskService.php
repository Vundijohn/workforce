<?php

namespace App\Services;

use App\Enums\ProjectStatus;
use App\Enums\TaskStatus;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class TaskService
{
    public const MAX_OPEN_TASKS = 3;
    public const DUE_HOURS = 24;

    public function __construct(private AuditLogger $audit)
    {
    }

    /**
     * Give the worker the next available task in a project.
     * Only fully onboarded (engaged) workers on an active project may claim.
     */
    public function claimNext(Project $project, User $user): Task
    {
        if (! $user->isActive()) {
            throw new RuntimeException('Your account is not active.');
        }

        if ($project->status !== ProjectStatus::Active) {
            throw new RuntimeException('This project is not accepting work.');
        }

        $application = $project->applications()->where('user_id', $user->id)->first();
        if (! $application || ! $application->status->canWork()) {
            throw new RuntimeException('You are not onboarded on this project.');
        }

        return DB::transaction(function () use ($project, $user) {
            $open = Task::where('assigned_to', $user->id)
                ->whereIn('status', array_map(fn ($s) => $s->value, TaskStatus::workable()))
                ->count();

            if ($open >= self::MAX_OPEN_TASKS) {
                throw new RuntimeException('Finish your open tasks before claiming more.');
            }

            // SKIP LOCKED lets concurrent workers claim different tasks without blocking (MySQL 8+).
            // SQLite (local dev) ignores locking hints, which is fine for a single user.
            $task = $project->availableTasks()->lock('for update skip locked')->first();

            if (! $task) {
                throw new RuntimeException('No tasks are available right now.');
            }

            $task->update([
                'assigned_to' => $user->id,
                'status' => TaskStatus::Assigned,
                'claimed_at' => now(),
                'due_at' => now()->addHours(self::DUE_HOURS),
            ]);

            $this->audit->log('task.claimed', $task);

            return $task;
        });
    }
}

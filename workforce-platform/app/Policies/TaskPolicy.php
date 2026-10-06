<?php

namespace App\Policies;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\User;

class TaskPolicy
{
    public function view(User $user, Task $task): bool
    {
        return $user->isActive()
            && ($task->assigned_to === $user->id || $user->can('review_submissions'));
    }

    public function submit(User $user, Task $task): bool
    {
        return $user->isActive()
            && $task->assigned_to === $user->id
            && in_array($task->status, TaskStatus::workable(), true);
    }
}

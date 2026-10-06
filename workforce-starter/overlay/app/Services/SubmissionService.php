<?php

namespace App\Services;

use App\Enums\EarningStatus;
use App\Enums\ReviewDecision;
use App\Enums\SubmissionStatus;
use App\Enums\TaskStatus;
use App\Models\Earning;
use App\Models\Review;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class SubmissionService
{
    /** Days an approved earning stays "pending" before it can be paid out. Revisit in Phase 4. */
    public const HOLDING_DAYS = 3;

    public function __construct(private AuditLogger $audit)
    {
    }

    public function submit(Task $task, User $worker, array $response): TaskSubmission
    {
        return DB::transaction(function () use ($task, $worker, $response) {
            $task = Task::whereKey($task->id)->lockForUpdate()->firstOrFail();

            if ($task->assigned_to !== $worker->id || ! in_array($task->status, TaskStatus::workable(), true)) {
                throw new RuntimeException('This task cannot be submitted.');
            }

            $submission = TaskSubmission::create([
                'task_id' => $task->id,
                'user_id' => $worker->id,
                'response' => $response,
                'status' => SubmissionStatus::Submitted,
                'submitted_at' => now(),
            ]);

            $task->update(['status' => TaskStatus::Submitted]);
            $this->audit->log('submission.created', $submission);

            return $submission;
        });
    }

    public function review(TaskSubmission $submission, User $reviewer, ReviewDecision $decision, ?int $score, ?string $comments): Review
    {
        return DB::transaction(function () use ($submission, $reviewer, $decision, $score, $comments) {
            $submission = TaskSubmission::whereKey($submission->id)->lockForUpdate()->firstOrFail();

            if ($submission->status !== SubmissionStatus::Submitted) {
                throw new RuntimeException('This submission has already been reviewed.');
            }

            if ($submission->user_id === $reviewer->id) {
                throw new RuntimeException('You cannot review your own work.');
            }

            $task = $submission->task()->lockForUpdate()->firstOrFail();

            $review = Review::create([
                'task_submission_id' => $submission->id,
                'reviewer_id' => $reviewer->id,
                'decision' => $decision,
                'score' => $score,
                'comments' => $comments,
            ]);

            [$submissionStatus, $taskStatus] = match ($decision) {
                ReviewDecision::Approved => [SubmissionStatus::Approved, TaskStatus::Approved],
                ReviewDecision::RevisionRequested => [SubmissionStatus::RevisionRequested, TaskStatus::RevisionRequired],
                ReviewDecision::Rejected => [SubmissionStatus::Rejected, TaskStatus::Rejected],
            };

            $submission->update(['status' => $submissionStatus]);
            $task->update(['status' => $taskStatus]);

            if ($decision === ReviewDecision::Approved) {
                // Unique(task_submission_id) guarantees at most one earning per submission.
                Earning::create([
                    'user_id' => $submission->user_id,
                    'task_submission_id' => $submission->id,
                    'amount_minor' => $task->project->pay_rate_minor,
                    'currency' => $task->project->currency,
                    'status' => EarningStatus::Pending,
                    'available_at' => now()->addDays(self::HOLDING_DAYS),
                ]);
            }

            $this->audit->log('submission.reviewed', $submission, ['decision' => $decision->value, 'reviewer' => $reviewer->id]);

            return $review;
        });
    }
}

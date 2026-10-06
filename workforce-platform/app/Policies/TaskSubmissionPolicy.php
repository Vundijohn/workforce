<?php

namespace App\Policies;

use App\Enums\SubmissionStatus;
use App\Models\TaskSubmission;
use App\Models\User;

class TaskSubmissionPolicy
{
    public function view(User $user, TaskSubmission $submission): bool
    {
        return $user->isActive()
            && ($submission->user_id === $user->id || $user->can('review_submissions'));
    }

    /** Reviewers can review submitted work, but never their own. */
    public function review(User $user, TaskSubmission $submission): bool
    {
        return $user->isActive()
            && $user->can('review_submissions')
            && $submission->user_id !== $user->id
            && $submission->status === SubmissionStatus::Submitted;
    }
}

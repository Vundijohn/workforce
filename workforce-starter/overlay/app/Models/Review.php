<?php

namespace App\Models;

use App\Enums\ReviewDecision;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Review extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['decision' => ReviewDecision::class];
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(TaskSubmission::class, 'task_submission_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }
}

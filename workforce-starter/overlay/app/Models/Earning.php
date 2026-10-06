<?php

namespace App\Models;

use App\Enums\EarningStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * MVP earnings record. One row per approved submission (unique constraint makes approval idempotent).
 * Amounts are integer minor units (KES cents). In Phase 4 this is superseded by the double-entry ledger.
 */
class Earning extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['status' => EarningStatus::class, 'available_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function submission(): BelongsTo
    {
        return $this->belongsTo(TaskSubmission::class, 'task_submission_id');
    }
}

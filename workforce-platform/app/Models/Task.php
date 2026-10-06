<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'status' => TaskStatus::class,
            'payload' => 'array',
            'due_at' => 'datetime',
            'claimed_at' => 'datetime',
        ];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function assignee(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function submissions(): HasMany
    {
        return $this->hasMany(TaskSubmission::class);
    }
}

<?php

namespace App\Models;

use App\Enums\ProjectStatus;
use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Project extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['status' => ProjectStatus::class, 'opens_at' => 'datetime'];
    }

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(ProjectApplication::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function availableTasks(): HasMany
    {
        return $this->tasks()->where('status', TaskStatus::Available->value);
    }

    /** Pay per approved task, formatted for display. */
    public function payRateLabel(): string
    {
        return $this->currency === 'USD'
            ? '$'.number_format($this->pay_rate_minor / 100, 2)
            : $this->currency.' '.number_format($this->pay_rate_minor / 100, 2);
    }
}

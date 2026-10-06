<?php

namespace App\Models;

use App\Enums\ApplicationStatus;
use App\Services\AuditLogger;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use InvalidArgumentException;

class ProjectApplication extends Model
{
    protected $guarded = [];

    protected function casts(): array
    {
        return ['status' => ApplicationStatus::class];
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /** The only sanctioned way to change an application's status. */
    public function transitionTo(ApplicationStatus $to, ?User $by = null): void
    {
        if (! $this->status->canTransitionTo($to)) {
            throw new InvalidArgumentException("Cannot move application from {$this->status->value} to {$to->value}.");
        }

        $from = $this->status;
        $this->update(['status' => $to]);

        app(AuditLogger::class)->log('application.status_changed', $this, [
            'from' => $from->value,
            'to' => $to->value,
            'by' => $by?->id,
        ]);
    }
}

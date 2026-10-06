<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkerProfile extends Model
{
    // Only ever fill from validated data, never request()->all().
    protected $guarded = [];

    protected function casts(): array
    {
        return ['skills' => 'array', 'languages' => 'array', 'verified_at' => 'datetime'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

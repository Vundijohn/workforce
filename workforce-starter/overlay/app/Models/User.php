<?php

namespace App\Models;

use App\Enums\Role;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Models\Role as SpatieRole;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable, HasRoles;

    // `status` is deliberately NOT fillable so it can never be set from a request.
    protected $fillable = ['name', 'email', 'password', 'phone', 'country'];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(): void
    {
        // Self-registered users are always plain workers. Staff roles are assigned by admins/seeders only.
        static::created(function (User $user) {
            SpatieRole::findOrCreate(Role::Worker->value, 'web');
            $user->assignRole(Role::Worker->value);
        });
    }

    public function isActive(): bool
    {
        return ($this->status ?? 'active') === 'active';
    }

    public function workerProfile(): HasOne
    {
        return $this->hasOne(WorkerProfile::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(ProjectApplication::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }

    public function earnings(): HasMany
    {
        return $this->hasMany(Earning::class);
    }
}

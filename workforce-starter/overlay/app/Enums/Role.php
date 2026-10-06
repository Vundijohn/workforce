<?php

namespace App\Enums;

enum Role: string
{
    case Worker = 'worker';
    case Client = 'client';
    case Reviewer = 'reviewer';
    case Admin = 'admin';
    case SuperAdmin = 'super_admin';

    /** Permissions each role receives (seeded by RolesAndPermissionsSeeder). */
    public function permissions(): array
    {
        return match ($this) {
            self::Worker => ['apply_to_projects', 'work_on_tasks'],
            self::Client => ['manage_own_projects'],
            self::Reviewer => ['review_submissions'],
            self::Admin => ['manage_projects', 'manage_applications', 'review_submissions', 'manage_users'],
            self::SuperAdmin => ['manage_projects', 'manage_applications', 'review_submissions', 'manage_users', 'manage_payouts', 'manage_settings'],
        };
    }
}

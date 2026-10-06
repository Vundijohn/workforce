<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Available = 'available';
    case Assigned = 'assigned';
    case Submitted = 'submitted';
    case RevisionRequired = 'revision_required';
    case Approved = 'approved';
    case Rejected = 'rejected';

    /** Statuses in which the assigned worker may (re)submit. */
    public static function workable(): array
    {
        return [self::Assigned, self::RevisionRequired];
    }
}

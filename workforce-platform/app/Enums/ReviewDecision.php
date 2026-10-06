<?php

namespace App\Enums;

enum ReviewDecision: string
{
    case Approved = 'approved';
    case RevisionRequested = 'revision_requested';
    case Rejected = 'rejected';
}

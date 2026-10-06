<?php

namespace App\Enums;

enum SubmissionStatus: string
{
    case Submitted = 'submitted';
    case Approved = 'approved';
    case RevisionRequested = 'revision_requested';
    case Rejected = 'rejected';
}

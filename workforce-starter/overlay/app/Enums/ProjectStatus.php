<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Draft = 'draft';
    case Active = 'active';
    case Paused = 'paused';
    case Closed = 'closed';
}

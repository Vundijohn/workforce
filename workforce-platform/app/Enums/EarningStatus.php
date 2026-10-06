<?php

namespace App\Enums;

enum EarningStatus: string
{
    case Pending = 'pending';     // inside the holding period
    case Available = 'available'; // can be paid out
    case Paid = 'paid';           // marked paid (manual in MVP, automated in Phase 4)
}

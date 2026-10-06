<?php

namespace App\Enums;

enum ApplicationStatus: string
{
    case Submitted = 'submitted';
    case Screening = 'screening';
    case Shortlisted = 'shortlisted';
    case Selected = 'selected';
    case Onboarding = 'onboarding';
    case Engaged = 'engaged';
    case Rejected = 'rejected';
    case Withdrawn = 'withdrawn';

    /** @return array<self> */
    public function allowedNext(): array
    {
        return match ($this) {
            self::Submitted => [self::Screening, self::Rejected, self::Withdrawn],
            self::Screening => [self::Shortlisted, self::Rejected, self::Withdrawn],
            self::Shortlisted => [self::Selected, self::Rejected, self::Withdrawn],
            self::Selected => [self::Onboarding, self::Withdrawn],
            self::Onboarding => [self::Engaged, self::Withdrawn],
            self::Engaged => [self::Withdrawn],
            default => [],
        };
    }

    public function canTransitionTo(self $to): bool
    {
        return in_array($to, $this->allowedNext(), true);
    }

    /** Only fully onboarded workers may receive tasks. */
    public function canWork(): bool
    {
        return $this === self::Engaged;
    }
}

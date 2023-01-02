<?php

namespace App\Components\Domain\ValueObjects;

class ChecklistValueObject
{
    public function __construct(
        private readonly string $title,
        private readonly int $active,
        private readonly string $interval,
        private readonly string $activeDays,
        private readonly string $timeIntervals,
        private readonly ?string $deadlineDate,
        private readonly string $questions,
        private readonly string $permissions
    ) {}

    public function getTitle(): string
    {
        return $this->title;
    }

    public function isActive(): int
    {
        return $this->active;
    }

    public function getInterval(): string
    {
        return $this->interval;
    }

    public function getActiveDays(): string
    {
        return $this->activeDays;
    }

    public function getDeadlineDate(): ?string
    {
        return $this->deadlineDate;
    }

    public function getQuestions(): string
    {
        return $this->questions;
    }

    public function getPermissions(): string
    {
        return $this->permissions;
    }

    public function getTimeIntervals(): string
    {
        return $this->timeIntervals;
    }
}

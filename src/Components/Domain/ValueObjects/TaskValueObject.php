<?php

namespace App\Components\Domain\ValueObjects;

class TaskValueObject
{
    public function __construct(
        private readonly string $taskTitle,
        private readonly int $createdByUser,
        private readonly string $description,
        private readonly string $priority,
        private readonly string $dueDateType,
        private readonly string $dueDate,
        private readonly bool $photoRequired,
        private readonly bool $commentRequired,
        private readonly string $storeChars
    ) {}

    public function getTaskTitle(): string
    {
        return $this->taskTitle;
    }

    public function getCreatedByUser(): int
    {
        return $this->createdByUser;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPriority(): string
    {
        return $this->priority;
    }

    public function getDueDateType(): string
    {
        return $this->dueDateType;
    }

    public function getDueDate(): string
    {
        return $this->dueDate;
    }

    public function getPhotoRequired(): bool
    {
        return $this->photoRequired;
    }

    public function getStoreChars(): string
    {
        return $this->storeChars;
    }

    public function getCommentRequired(): bool
    {
        return $this->commentRequired;
    }
}

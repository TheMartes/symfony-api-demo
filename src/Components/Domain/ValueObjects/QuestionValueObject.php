<?php

namespace App\Components\Domain\ValueObjects;

class QuestionValueObject
{
    private string $title;
    private string $description;
    private string $expectedAnswer;
    private bool $photoRequired;
    private bool $commentRequired;
    private int $points;
    private ?int $taskID;
    private string $company;

    /**
     * @param string $title
     * @param string $description
     * @param string $expectedAnswer
     * @param bool $photoRequired
     * @param bool $commentRequired
     * @param int $points
     * @param int $taskID
     * @param string $company
     */
    public function __construct(string $title, string $description, string $expectedAnswer, bool $photoRequired, bool $commentRequired, int $points, string $company, ?int $taskID)
    {
        $this->title = $title;
        $this->description = $description;
        $this->expectedAnswer = $expectedAnswer;
        $this->photoRequired = $photoRequired;
        $this->commentRequired = $commentRequired;
        $this->points = $points;
        $this->taskID = $taskID;
        $this->company = $company;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getExpectedAnswer(): string
    {
        return $this->expectedAnswer;
    }

    /**
     * @return bool
     */
    public function isPhotoRequired(): bool
    {
        return $this->photoRequired;
    }

    /**
     * @return bool
     */
    public function isCommentRequired(): bool
    {
        return $this->commentRequired;
    }

    /**
     * @return int
     */
    public function getPoints(): int
    {
        return $this->points;
    }

    /**
     * @return int
     */
    public function getTaskID(): ?int
    {
        return $this->taskID;
    }

    /**
     * @return string
     */
    public function getCompany(): string
    {
        return $this->company;
    }
}

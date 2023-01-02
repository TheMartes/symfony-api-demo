<?php

namespace App\Components\Domain\Validators;

class TasksValidator
{
    /** @var array<string, string> */
    private array $data;

    /** @var string[] */
    private array $requiredFields = [
        "task_title",
        "description",
        "priority",
        "due_date_type",
        "due_date",
    ];

    /**
     * @param array<string, string> $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(): bool
    {
        $isValid = true;

        foreach ($this->requiredFields as $requiredField) {
            if (!array_key_exists($requiredField, $this->data)) {
                $isValid = false;
            }
        }

        return $isValid;
    }
}

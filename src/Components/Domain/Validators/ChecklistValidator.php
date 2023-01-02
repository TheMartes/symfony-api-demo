<?php

namespace App\Components\Domain\Validators;

class ChecklistValidator
{
    /** @var array<string, string> */
    private array $data;

    /** @var string[] */
    private array $requiredFields = [
        'title',
        'active',
        'interval',
        'active_days',
        'time_intervals',
        'questions'
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

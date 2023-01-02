<?php

namespace App\Components\Domain\Validators;

class QuestionsValidator
{
    /** @var array<string, string> */
    private array $data;

    /** @var string[] */
    private array $requiredFields = [
       'question_title',
       'expected_answer',
       'photo_required',
       'comment_required',
       'points',
       'task_id',
       'company',
       'description',
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

<?php

namespace App\Components\Domain\Validators;

class UserValidator
{
    /** @var array<string, string> */
    private array $data;

    /** @var string[] */
    private array $requiredFields = [
        'name', 'email', 'lang', 'role', 'preset', 'active'
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

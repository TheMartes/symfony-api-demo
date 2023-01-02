<?php

namespace App\Components\Domain\ValueObjects;

class UserValueObject
{
    private string $name;
    private string $email;
    private string $lang;
    private string $role;
    private ?string $password;
    private string $preset;
    private string $active;

    public function __construct(
        string $name,
        string $email,
        string $lang,
        string $role,
        ?string $password,
        string $preset,
        string $active,
    )
    {
        $this->name = $name;
        $this->role = $role;
        $this->email = $email;
        $this->lang = $lang;
        $this->password = $password;
        $this->preset = $preset;
        $this->active = $active;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getLang(): string
    {
        return $this->lang;
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return $this->role;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    /**
     * @return string
     */
    public function getPreset(): string
    {
        return $this->preset;
    }

    /**
     * @return string
     */
    public function getActive(): string
    {
        return $this->active;
    }
}

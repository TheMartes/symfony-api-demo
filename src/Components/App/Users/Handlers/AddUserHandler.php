<?php

namespace App\Components\App\Users\Handlers;

use App\Components\Domain\Case\UsersCase;

class AddUserHandler
{
    private UsersCase $case;

    public function __construct(
        UsersCase $case,
    )
    {
        $this->case = $case;
    }

    public function execute(
        string $name,
        string $email,
        string $lang,
        string $role,
        string $password,
        string $preset,
        int $active
    ): void
    {
        $this->case->addUser($name, $email, $lang, $role, $password, $preset, $active);
    }
}

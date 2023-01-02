<?php

namespace App\Components\App\Users\Handlers;

use App\Components\Domain\Case\UsersCase;

class EditUserHandler
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
        string $preset,
        int $active,
        int $userId,
        ?string $password
    ): void
    {
        $this->case->editUser($name, $email, $lang, $role, $preset, $active, $userId, $password);
    }
}

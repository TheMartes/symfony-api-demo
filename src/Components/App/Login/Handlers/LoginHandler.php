<?php

namespace App\Components\App\Login\Handlers;

use App\Components\Domain\Case\LoginCase;

class LoginHandler
{
    private LoginCase $case;

    /**
     * @param LoginCase $case
     */
    public function __construct(LoginCase $case)
    {
        $this->case = $case;
    }

    public function execute($credentials): ?string
    {
        return $this->case->loginUser($credentials);
    }
}

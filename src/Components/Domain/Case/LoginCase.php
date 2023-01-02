<?php

namespace App\Components\Domain\Case;

use App\Components\Domain\Helpers\JWTHelper;
use App\Components\Infrastructure\MySQL\Queries\Login\LoginUserQuery;
use Dibi\Exception;

class LoginCase
{
    private LoginUserQuery $loginUserQuery;

    public function __construct(LoginUserQuery $loginUserQuery)
    {
        $this->loginUserQuery = $loginUserQuery;
    }

    /**
     * @throws Exception
     */
    public function loginUser(array $credentials): ?string
    {
        /**
            :))))
         */

        return $token;
    }
}

<?php

namespace App\Components\Infrastructure\MySQL\Queries\Login;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use Dibi\Exception;

class LoginUserQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     * @return mixed|int
     */
    public function execute(string $username, string $password)
    {
        if ($this->singleton->getConnection() === null) {
            throw new Exception(DBErrorEnum::ConnectionNotOpened->name);
        }

        $connection = $this->singleton->getConnection();

        $userIdQuery = $connection->query($this->getUserId(), $username, $password);

        return $userIdQuery->fetchSingle();
    }

    private function getUserId(): string
    {
        return "";
    }
}

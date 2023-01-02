<?php

namespace App\Components\Infrastructure\MySQL\Queries\Users;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use Dibi\Exception;

class GetAllUsersQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(?int $idUser = 0): ?string
    {
        if ($this->singleton->getConnection() === null) {
            throw new Exception(DBErrorEnum::ConnectionNotOpened->name);
        }

        $connection = $this->singleton->getConnection();

        $query = $connection->query($this->query());

        $output = json_encode($query->fetchAll());

        return $output === false ? null : $output;
    }

    private function query(): string
    {
        return "";
    }
}

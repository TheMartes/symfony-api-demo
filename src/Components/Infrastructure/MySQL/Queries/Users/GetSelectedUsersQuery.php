<?php

namespace App\Components\Infrastructure\MySQL\Queries\Users;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use Dibi\Exception;

class GetSelectedUsersQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(array $ids): ?array
    {
        if ($this->singleton->getConnection() === null) {
            throw new Exception(DBErrorEnum::ConnectionNotOpened->name);
        }

        $connection = $this->singleton->getConnection();

        $query = $connection->query($this->query(), $ids);

        $output = $query->fetchPairs('id', 'name');

        return $output === false ? null : $output;
    }

    private function query(): string
    {
        return "";
    }
}

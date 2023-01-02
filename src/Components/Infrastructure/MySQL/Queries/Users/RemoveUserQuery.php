<?php

namespace App\Components\Infrastructure\MySQL\Queries\Users;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use Dibi\Connection;
use Dibi\Exception;

class RemoveUserQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(int $id): void
    {
        if ($this->singleton->getConnection() === null) {
            throw new Exception(DBErrorEnum::ConnectionNotOpened->name);
        }

        $connection = $this->singleton->getConnection();

        $this->unpairFromComapny($id, $connection);
        $this->unsetSettings($id, $connection);
        $query = $connection->query($this->query(), $id);
    }

    private function query(): string
    {
        return "";
    }

    private function unsetSettings(int $id, Connection $connection): void
    {
        $connection->query("", $id);
    }

    private function unpairFromComapny(int $id, Connection $connection): void
    {
        $connection->query("", $id);
    }
}

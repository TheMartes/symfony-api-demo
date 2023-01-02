<?php

namespace App\Components\Infrastructure\MySQL\Queries\Users;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use Dibi\Exception;
use Dibi\Row;

class GetUserCompanyDBInformation extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(int $id): Row
    {
        if ($this->singleton->getConnection() === null) {
            throw new Exception(DBErrorEnum::ConnectionNotOpened->name);
        }

        $connection = $this->singleton->getConnection();

        $query = $connection->query($this->query(), $id);

        return $query->fetchAll()[0];
    }

    private function query(): string
    {
        return "";
    }
}

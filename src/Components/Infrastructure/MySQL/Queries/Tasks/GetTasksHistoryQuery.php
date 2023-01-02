<?php

namespace App\Components\Infrastructure\MySQL\Queries\Tasks;

use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetTasksHistoryQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(string $clientDBName): array
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $query = $connection->query($this->query());

        return $query->fetchAll();
    }

    private function query(): string
    {
        return "";
    }
}

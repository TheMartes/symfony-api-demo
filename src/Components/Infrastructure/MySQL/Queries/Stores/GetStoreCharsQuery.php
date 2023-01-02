<?php

namespace App\Components\Infrastructure\MySQL\Queries\Stores;

use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetStoreCharsQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(string $clientDBName): string
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $dbRaw = $connection->fetchAll($this->query());

        $data = ($connection->getAffectedRows() !== 0) ? $dbRaw : [];

        return json_encode($data);
    }

    private function query(): string
    {
        return "
        ";
    }
}

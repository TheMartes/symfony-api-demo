<?php

namespace App\Components\Infrastructure\MySQL\Queries\Checklists;

use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetChecklistsHistoryQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(string $companyDBName): array
    {
        $connectionValueObject = new ClientDatabaseConnection($companyDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $query = $connection->query($this->query());

        return $query->fetchAll();
    }

    private function query(): string
    {
        return "
        ";
    }
}

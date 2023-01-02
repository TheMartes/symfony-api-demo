<?php

namespace App\Components\Infrastructure\MySQL\Queries\Checklists;

use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetAllChecklistsQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(string $companyDBName): ?string
    {
        $connectionValueObject = new ClientDatabaseConnection($companyDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $query = $connection->query($this->query());

        $output = json_encode($query->fetchAll());

        return $output === false ? null : $output;
    }

    private function query(): string
    {
        return "
        ";
    }
}

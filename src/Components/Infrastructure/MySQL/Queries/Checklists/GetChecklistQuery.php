<?php

namespace App\Components\Infrastructure\MySQL\Queries\Checklists;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetChecklistQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(int $id, $companyDBName): ?string
    {
        $connectionValueObject = new ClientDatabaseConnection($companyDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $query = $connection->query($this->query(), $id, $id);

        $output = json_encode($query->fetchAll()[0]);

        return $output === false ? null : $output;
    }

    private function query(): string
    {
        return "
        ";
    }
}

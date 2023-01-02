<?php

namespace App\Components\Infrastructure\MySQL\Queries\Checklists;

use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetChecklistHistoryDetailQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(int $id, string $companyDBName): array
    {
        $connectionValueObject = new ClientDatabaseConnection($companyDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $query = $connection->query($this->query(), $id);

        $output = [];
        $output['questions'] = $query->fetchAll();
        $output['general_info'] = $connection->query($this->generalInfoQuery(), $id)->fetchAll()[0];

        return $output;
    }

    private function query(): string
    {
        return "
        ";
    }

    private function generalInfoQuery(): string
    {
        return "
        ";
    }
}

<?php

namespace App\Components\Infrastructure\MySQL\Queries\Checklists;

use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetAnswersForChecklistQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(array $ids, string $companyDBName): array
    {
        $connectionValueObject = new ClientDatabaseConnection($companyDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $query = $connection->query($this->query(), $ids);

        return $query->fetchAssoc('checklist_record_id|question_id');
    }

    private function query(): string
    {
        return "";
    }
}

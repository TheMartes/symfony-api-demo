<?php

namespace App\Components\Infrastructure\MySQL\Queries\Questions;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class RemoveQuestionQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(int $id, string $clientDBName): void
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $query = $connection->query($this->query(), $id);

        $query->fetchAll();
    }

    private function query(): string
    {
        return "";
    }
}

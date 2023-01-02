<?php

namespace App\Components\Infrastructure\MySQL\Queries\Questions;

use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetQuestionQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(int $id, string $clientDBName): ?string
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $query = $connection->query($this->query(), $id);

        $output = json_encode($query->fetchAll()[0]);

        return $output === false ? null : $output;
    }

    private function query(): string
    {
        return "
        ";
    }
}

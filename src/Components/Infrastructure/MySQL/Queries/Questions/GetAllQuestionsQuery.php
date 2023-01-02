<?php

namespace App\Components\Infrastructure\MySQL\Queries\Questions;

use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetAllQuestionsQuery
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(int $idCompany, string $clientDBName): ?string
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

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

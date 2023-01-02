<?php

namespace App\Components\Infrastructure\MySQL\Queries\Tasks;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetTaskQuery extends Query
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
        $output = $query->fetchAll()[0];

        $output['chars'] = $connection->query($this->getChars(), $id)->fetchAll();

        $output = json_encode($output);

        return $output === false ? null : $output;
    }

    private function query(): string
    {
        return "
        ";
    }

    private function getChars(): string
    {
        return "
        ";
    }
}

<?php

namespace App\Components\Infrastructure\MySQL\Queries\Stores;

use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class AddOrEditCharsQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(array $chars, int $id, string $clientDBName): void
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        // Fuck 'em
        $connection->query("", $id);

        // Load 'em
        // @TODO: probably refactor to one query
        foreach ($chars as $key => $value) {
            $connection->query("", [
            ]);
        }
    }
}


<?php

namespace App\Components\Infrastructure\MySQL\Queries\Stores;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class GetStoreQuery extends Query
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

        $chars = $connection->query($this->storeCharsQuery(), $id);

        $output['storeChars'] = $chars->fetchPairs('attribute', 'value');

        $output = json_encode($output);

        return $output === false ? null : $output;
    }

    private function query(): string
    {
        return "
        ";
    }

    private function storeCharsQuery(): string
    {
        return "
        ";
    }
}

<?php

namespace App\Components\Infrastructure\MySQL\Queries\Tasks;

use App\Components\Domain\ValueObjects\TaskValueObject;
use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Connection;
use Dibi\Exception;

class GetStoreCharsByTaskIds extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(array $ids, string $clientDBName): array
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        return $connection->query($this->query(), $ids)->fetchPairs('table_id', 'value');
    }

    private function query(): string
    {
        return "
        ";
    }

}

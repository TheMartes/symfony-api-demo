<?php

namespace App\Components\Infrastructure\MySQL\Queries\Stores;

use App\Components\Domain\ValueObjects\StoreValueObject;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class EditStoreQuery extends Query
{
    public function __construct(
        private AddOrEditCharsQuery $addOrEditCharsQuery
    ) {}

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(StoreValueObject $vo, int $id, string $clientDBName): void
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $args = [
            "store_name" => $vo->getStoreName(),
            "store_code" => $vo->getStoreCode(),
            "active" => $vo->getActive(),
            "opening_date" => $vo->getOpeningDate(),
            "closing_date" => $vo->getClosingDate(),
        ];

        $connection->query($this->query(), $args, $id);

        $this->addOrEditCharsQuery->execute($vo->getStoreChars(), $id, $clientDBName);
    }

    private function query(): string
    {
        return "
        ";
    }
}

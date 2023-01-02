<?php

namespace App\Components\Domain\Case;

use App\Components\Domain\Helpers\JWTHelper;
use App\Components\Domain\ValueObjects\StoreValueObject;
use App\Components\Infrastructure\MySQL\Queries\Stores\AddOrEditCharsQuery;
use App\Components\Infrastructure\MySQL\Queries\Stores\GetStoreQuery;
use App\Components\Infrastructure\MySQL\Queries\Stores\RemoveStoreQuery;
use App\Components\Infrastructure\MySQL\Queries\Stores\AddStoreQuery;
use App\Components\Infrastructure\MySQL\Queries\Stores\EditStoreQuery;
use App\Components\Infrastructure\MySQL\Queries\Stores\GetAllStoresQuery;
use App\Components\Infrastructure\MySQL\Queries\Stores\GetStoreChars;
use App\Components\Infrastructure\MySQL\Queries\Stores\GetStoreCharsQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\GetUserCompanyDBInformation;
use Dibi\Exception;
use Dibi\Row;

class StoresCase
{
    private Row $companyDBInfo;

    public function __construct(
        private GetAllStoresQuery $getAllStoresQuery,
        private RemoveStoreQuery $removeStoreQuery,
        private AddStoreQuery $addStoreQuery,
        private EditStoreQuery $editStoreQuery,
        private GetStoreQuery $getStoreQuery,
        private GetStoreChars $getStoreChars,
        private GetStoreCharsQuery $getStoreCharsQuery,
        private GetUserCompanyDBInformation $getUserCompanyDBInformation,
        private AddOrEditCharsQuery $addOrEditCharsQuery
    )
    {
        $this->companyDBInfo = $this->getCompanyDBInfo();
    }


    /**
     * @throws Exception
     * @throws \Exception
     */
    public function getAllStores(): ?string
    {
        $stores = $this->getAllStoresQuery->execute($this->companyDBInfo['dbName']);
        $storeIDs = [];

        foreach ($stores as $store) {
            \array_push($storeIDs, $store['id']);
        }

        $storeChars = $this->getStoreChars->execute($storeIDs, $this->companyDBInfo['dbName']);
        $beautifiedChars = [];

        foreach ($storeChars as $char) {
            $beautifiedChars[$char['table_id']][] = [
                'char' => $char['attribute'],
                'value' => $char['value']
            ];
        }

        foreach ($stores as $store) {
            $store['chars'] = $beautifiedChars[$store['id']] ?? [];
        }

        return \json_encode($stores);
    }

    public function getAllChars(): string
    {
        return $this->getStoreCharsQuery->execute($this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function removeStore(int $id): void
    {
        $this->removeStoreQuery->execute($id, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function addStore(StoreValueObject $vo): void
    {
        $this->addStoreQuery->execute($vo, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function editStore(StoreValueObject $vo, int $id): void
    {
        $this->editStoreQuery->execute($vo, $id, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function getStore(int $id): ?string
    {
        return $this->getStoreQuery->execute($id, $this->companyDBInfo['dbName']);
    }

    private function getCompanyDBInfo(): Row
    {
        return $this->getUserCompanyDBInformation->execute(JWTHelper::getUserData()['id']);
    }
}

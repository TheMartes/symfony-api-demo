<?php

namespace App\Components\App\Stores\Handlers;

use App\Components\Domain\Case\StoresCase;
use App\Components\Domain\Case\UsersCase;
use App\Components\Domain\ValueObjects\StoreValueObject;

class EditStoreHandler
{
    public function __construct(
        private StoresCase $case,
    )
    {}

    public function execute(
        StoreValueObject $vo,
        int $id
    ): void
    {
        $this->case->editStore($vo, $id);
    }
}

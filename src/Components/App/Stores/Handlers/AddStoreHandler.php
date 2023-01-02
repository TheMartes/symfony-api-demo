<?php

namespace App\Components\App\Stores\Handlers;

use App\Components\Domain\Case\StoresCase;
use App\Components\Domain\Case\UsersCase;
use App\Components\Domain\ValueObjects\StoreValueObject;

class AddStoreHandler
{
    public function __construct(
        private StoresCase $case,
    )
    {}

    public function execute(
        StoreValueObject $vo
    ): void
    {
        $this->case->addStore($vo);
    }
}

<?php

namespace App\Components\App\Stores\Handlers;

use App\Components\Domain\Case\StoresCase;
use App\Components\Domain\Case\UsersCase;
use Dibi\Exception;

class ViewAllStoresHandler
{
    public function __construct(
        private StoresCase $case,
    )
    {}

    /**
     * @throws Exception
     */
    public function execute(): ?string
    {
        return $this->case->getAllStores();
    }
}

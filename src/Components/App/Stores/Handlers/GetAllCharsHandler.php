<?php

namespace App\Components\App\Stores\Handlers;

use App\Components\Domain\Case\StoresCase;
use Dibi\Exception;

class GetAllCharsHandler
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
        return $this->case->getAllChars();
    }
}

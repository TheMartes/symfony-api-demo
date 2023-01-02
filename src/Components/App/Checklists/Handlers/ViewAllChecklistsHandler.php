<?php

namespace App\Components\App\Checklists\Handlers;

use App\Components\Domain\Case\UsersCase;
use App\Components\Domain\Case\ChecklistsCase;
use Dibi\Exception;

class ViewAllChecklistsHandler
{
    public function __construct(private ChecklistsCase $case) {}

    /**
     * @throws Exception
     */
    public function execute(): ?string
    {
        return $this->case->getAllChecklists();
    }
}

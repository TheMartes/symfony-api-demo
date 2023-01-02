<?php

namespace App\Components\App\Checklists\Handlers;

use Dibi\Exception;
use App\Components\Domain\Case\ChecklistsCase;

class ViewChecklistsHistoryHandler
{
    public function __construct(private ChecklistsCase $case) {}

    /**
     * @throws Exception
     */
    public function execute(): ?string
    {
        return $this->case->getAllHistoryChecklists();
    }
}

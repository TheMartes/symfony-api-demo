<?php

namespace App\Components\App\Checklists\Handlers;

use App\Components\Domain\Case\ChecklistsCase;
use Dibi\Exception;

class RemoveChecklistHandler
{
    public function __construct(private ChecklistsCase $case) {}

    /**
     * @throws Exception
     */
    public function execute(int $id): void
    {
        $this->case->removeChecklist($id);
    }
}

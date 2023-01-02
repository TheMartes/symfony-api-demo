<?php

namespace App\Components\App\Checklists\Handlers;

use App\Components\Domain\Case\UsersCase;
use Dibi\Exception;
use App\Components\Domain\Case\ChecklistsCase;

class ViewChecklistHandler
{
    public function __construct(private ChecklistsCase $case) {}

    /**
     * @throws Exception
     */
    public function execute(int $id): ?string
    {
        return $this->case->getChecklist($id);
    }
}
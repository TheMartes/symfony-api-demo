<?php

namespace App\Components\App\Checklists\Handlers;

use App\Components\Domain\Case\ChecklistsCase;
use App\Components\Domain\ValueObjects\ChecklistValueObject;

class EditChecklistHandler
{
    public function __construct(private ChecklistsCase $case) {}

    public function execute(ChecklistValueObject $vo, int $id): void
    {
        $this->case->editChecklist($vo, $id);
    }
}

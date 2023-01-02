<?php

namespace App\Components\App\Checklists\Handlers;

use App\Components\Domain\Case\ChecklistsCase;
use App\Components\Domain\ValueObjects\ChecklistValueObject;

class AddChecklistHandler
{
    public function __construct(private ChecklistsCase $case) {}

    public function execute(ChecklistValueObject $vo): void
    {
        $this->case->addChecklist($vo);
    }
}

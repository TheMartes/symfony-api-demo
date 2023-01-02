<?php

namespace App\Components\App\Tasks\Handlers;

use App\Components\Domain\Case\TasksCase;
use App\Components\Domain\Case\UsersCase;
use App\Components\Domain\ValueObjects\TaskValueObject;

class AddTaskHandler
{
    private TasksCase $case;

    public function __construct(
        TasksCase $case,
    )
    {
        $this->case = $case;
    }

    public function execute(TaskValueObject $vo): void
    {
        $this->case->addTask($vo);
    }
}

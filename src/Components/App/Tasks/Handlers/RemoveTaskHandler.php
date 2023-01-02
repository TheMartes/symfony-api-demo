<?php

namespace App\Components\App\Tasks\Handlers;

use App\Components\Domain\Case\TasksCase;
use App\Components\Domain\Case\UsersCase;
use Dibi\Exception;

class RemoveTaskHandler
{
    private TasksCase $case;

    public function __construct(
        TasksCase $case,
    )
    {
        $this->case = $case;
    }

    /**
     * @throws Exception
     */
    public function execute(int $id): void
    {
        $this->case->removeTask($id);
    }
}

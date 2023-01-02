<?php

namespace App\Components\App\Tasks\Handlers;

use App\Components\Domain\Case\TasksCase;
use Dibi\Exception;

class ViewAllTasksHandler
{
    public TasksCase $case;

    public function __construct(
        TasksCase $case,
    )
    {
        $this->case = $case;
    }

    /**
     * @throws Exception
     */
    public function execute(): ?string
    {
        return $this->case->getAllTasks();
    }
}

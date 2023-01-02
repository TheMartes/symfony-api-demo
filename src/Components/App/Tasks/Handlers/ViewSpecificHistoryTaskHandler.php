<?php

namespace App\Components\App\Tasks\Handlers;

use App\Components\Domain\Case\TasksCase;
use Dibi\Exception;

class ViewSpecificHistoryTaskHandler
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
    public function execute(int $id): ?string
    {
        return $this->case->getSpecificHistoryTask($id);
    }
}

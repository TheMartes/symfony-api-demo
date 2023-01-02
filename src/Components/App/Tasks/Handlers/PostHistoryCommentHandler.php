<?php

namespace App\Components\App\Tasks\Handlers;

use App\Components\Domain\Case\TasksCase;
use App\Components\Domain\Case\UsersCase;
use App\Components\Domain\ValueObjects\PostHistoryCommentValueObject;
use App\Components\Domain\ValueObjects\TaskValueObject;

class PostHistoryCommentHandler
{
    private TasksCase $case;

    public function __construct(
        TasksCase $case,
    )
    {
        $this->case = $case;
    }

    public function execute(PostHistoryCommentValueObject $vo, int $id): void
    {
        $this->case->postHistoryComment($vo, $id);
    }
}


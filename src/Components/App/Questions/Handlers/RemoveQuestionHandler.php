<?php

namespace App\Components\App\Questions\Handlers;

use App\Components\Domain\Case\QuestionsCase;
use Dibi\Exception;

class RemoveQuestionHandler
{
    private QuestionsCase $case;

    public function __construct(
        QuestionsCase $case,
    )
    {
        $this->case = $case;
    }

    /**
     * @throws Exception
     */
    public function execute(int $id): void
    {
        $this->case->removeQuestion($id);
    }
}

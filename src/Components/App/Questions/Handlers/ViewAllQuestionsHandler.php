<?php

namespace App\Components\App\Questions\Handlers;

use App\Components\Domain\Case\QuestionsCase;
use Dibi\Exception;

class ViewAllQuestionsHandler
{
    public QuestionsCase $case;

    public function __construct(
        QuestionsCase $case,
    )
    {
        $this->case = $case;
    }

    /**
     * @throws Exception
     */
    public function execute(): ?string
    {
        return $this->case->getAllQuestions();
    }
}

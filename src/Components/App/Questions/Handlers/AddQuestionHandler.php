<?php

namespace App\Components\App\Questions\Handlers;

use App\Components\Domain\Case\QuestionsCase;
use App\Components\Domain\ValueObjects\QuestionValueObject;

class AddQuestionHandler
{
    private QuestionsCase $case;

    public function __construct(
        QuestionsCase $case,
    )
    {
        $this->case = $case;
    }

    public function execute(QuestionValueObject $vo): void
    {
        $this->case->addQuestion($vo);
    }
}

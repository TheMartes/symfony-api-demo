<?php

namespace App\Components\App\Questions\Handlers;

use App\Components\Domain\Case\QuestionsCase;
use App\Components\Domain\ValueObjects\QuestionValueObject;

class EditQuestionHandler
{
    private QuestionsCase $case;

    public function __construct(
        QuestionsCase $case,
    )
    {
        $this->case = $case;
    }

    public function execute(QuestionValueObject $vo, int $id): void
    {
        $this->case->editQuestion($vo, $id);
    }
}

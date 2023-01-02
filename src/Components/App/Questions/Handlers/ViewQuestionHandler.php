<?php

namespace App\Components\App\Questions\Handlers;

use App\Components\Domain\Case\QuestionsCase;
use Dibi\Exception;

class ViewQuestionHandler
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
    public function execute(int $id): ?string
    {
        return $this->case->getQuestion($id);
    }
}

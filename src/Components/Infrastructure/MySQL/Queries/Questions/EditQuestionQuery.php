<?php

namespace App\Components\Infrastructure\MySQL\Queries\Questions;

use App\Components\Domain\ValueObjects\QuestionValueObject;
use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class EditQuestionQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(
        QuestionValueObject $vo,
        string $clientDBName,
        int $questionId,
    ): void
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $args = [
            "question_title" => $vo->getTitle(),
            "expected_answer" => $vo->getExpectedAnswer(),
            "photo_required" => (int) $vo->isPhotoRequired(),
            "comment_required" => (int) $vo->isCommentRequired(),
            "points" => $vo->getPoints(),
            "task_id" => $vo->getTaskID(),
            "company" => $vo->getCompany(),
            "description" => $vo->getDescription()
        ];

        $connection->query($this->query(), $args, $questionId);
    }

    private function query(): string
    {
        return "
        ";
    }
}

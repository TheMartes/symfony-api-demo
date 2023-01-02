<?php

namespace App\Components\Infrastructure\MySQL\Queries\Questions;

use App\Components\Domain\ValueObjects\QuestionValueObject;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Exception;

class AddQuestionQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(
        QuestionValueObject $questionValueObject,
        string $clientDBName
    ): void
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $args = [
            "question_title" => $questionValueObject->getTitle(),
            "expected_answer" => $questionValueObject->getExpectedAnswer(),
            "photo_required" => (int) $questionValueObject->isPhotoRequired(),
            "comment_required" => (int) $questionValueObject->isCommentRequired(),
            "points" => $questionValueObject->getPoints(),
            "task_id" => $questionValueObject->getTaskID(),
            "company" => $questionValueObject->getCompany(),
            "description" => $questionValueObject->getDescription()
        ];

        $connection->query($this->query(), $args);
    }

    private function query(): string
    {
        return "
        ";
    }
}

<?php

namespace App\Components\Infrastructure\MySQL\Queries\Tasks;

use App\Components\Domain\ValueObjects\TaskValueObject;
use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Connection;
use Dibi\Exception;

class AddTaskQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(TaskValueObject $vo, string $clientDBName): void
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $args = [
            "task_title" => $vo->getTaskTitle(),
            "created_by_user" => $vo->getCreatedByUser(),
            "description" => $vo->getDescription(),
            "priority" => $vo->getPriority(),
            "due_date_type" => $vo->getDueDateType(),
            "photo_required" => $vo->getPhotoRequired(),
            "comment_required" => $vo->getCommentRequired(),
            "due_date" => (int) $vo->getDueDate(), // @TODO: Same shit here xD ref: EditTaskQuery:29
        ];

        $connection->query($this->query(), $args);

        $taskAttributesArgs = [
            'table_name' => 'tasks',
            'table_id' => $connection->getInsertId(),
            'attribute' => 'settings',
            'value' => $vo->getStoreChars()
        ];

        $connection->query($this->insertTaskSettings(), $taskAttributesArgs);
    }

    private function query(): string
    {
        return "";
    }

    private function insertTaskSettings(): string
    {
        return "";
    }
}

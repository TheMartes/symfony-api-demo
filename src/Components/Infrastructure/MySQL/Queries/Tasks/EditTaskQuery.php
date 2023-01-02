<?php

namespace App\Components\Infrastructure\MySQL\Queries\Tasks;

use App\Components\Domain\ValueObjects\TaskValueObject;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use dibi;
use Dibi\Exception;

class EditTaskQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(TaskValueObject $vo, int $id, string $clientDBName): void
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
            "due_date" => (int) $vo->getDueDate(), // probably do the correct type checking :D
        ];

        $connection->query($this->query(), $args, $id);

        $updateSettingsArgs = [
            "value" => $vo->getStoreChars()
        ];

        $connection->query($this->pingTaskSettings(), $id);

        if ($connection->getAffectedRows() > 0) {
            $connection->query($this->updateTaskSettings(), $updateSettingsArgs, $id);
        } else {
            $connection->query($this->insertTaskSettings(), [
                "table_name" => 'tasks',
                "table_id" => $id,
                "attribute" => "settings",
                "value" => $vo->getStoreChars()
            ]);
        }

    }

    private function query(): string
    {
        return "
        ";
    }

    private function pingTaskSettings(): string
    {
        return "";
    }

    private function insertTaskSettings(): string
    {
        return "";
    }

    private function updateTaskSettings(): string
    {
        return "";
    }
}

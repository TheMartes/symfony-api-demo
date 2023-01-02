<?php

namespace App\Components\Infrastructure\MySQL\Queries\Checklists;

use App\Components\Domain\ValueObjects\ChecklistValueObject;
use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Connection;
use Dibi\Exception;

class AddChecklistQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(ChecklistValueObject $vo, string $companyDBName): void
    {
        $connectionValueObject = new ClientDatabaseConnection($companyDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $args = [
            'title' => $vo->getTitle(),
            'interval' => $vo->getInterval(),
            'active' => $vo->isActive(),
            'active_days' => $vo->getActiveDays(),
            'time_intervals' => $vo->getTimeIntervals(),
            'deadline_date' => $vo->getDeadlineDate(),
            'deleted_at' => '0000-00-00',
            'updated_at' => '0000-00-00',
            'created_at' => $connection->literal('NOW()'),
            'order' => '0',
        ];

        $connection->query($this->query(), $args);

        $checklistID = $connection->getInsertId();
        $this->pairQuestionsWithChecklist(json_decode($vo->getQuestions(), true), $checklistID, $connection);

        $permissionArgs = [
            'table_name' => 'checklists',
            'table_id' => $checklistID,
            'attribute' => 'permissions',
            'value' => $vo->getPermissions()
        ];

        $connection->query($this->addPermissionsQuery(), $permissionArgs);
    }

    private function query(): string
    {
        return "
            INSERT INTO checklists
        ";
    }

    private function pairQuestionsWithChecklist(array $questions, string $checklistID, Connection $connection): void
    {
        $query = "";
        $inc = 0;

        foreach ($questions as $question) {
            if ($question['id'] === null) { continue; }

            $connection->query($query, [
                'checklist_id' => $checklistID,
                'question_id' => $question['id'],
                'order' => $inc
            ]);

            $inc++;
        }
    }

    private function addPermissionsQuery(): string
    {
        return "";
    }
}

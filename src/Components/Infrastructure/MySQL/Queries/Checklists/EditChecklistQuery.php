<?php

namespace App\Components\Infrastructure\MySQL\Queries\Checklists;

use App\Components\Domain\ValueObjects\ChecklistValueObject;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use Dibi\Connection;
use Dibi\Exception;

class EditChecklistQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(ChecklistValueObject $vo, int $id, string $companyDBName): void
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
            'deadline_date' => $vo->getDeadlineDate() ?? '0000-00-00',
            'deleted_at' => '0000-00-00',
            'updated_at' => $connection->literal('NOW()'),
        ];

        $query = $connection->query($this->query(), $args, $id);
        $this->pairQuestionsWithChecklist(json_decode($vo->getQuestions(), true), $id, $connection);

        $permissions = [
            'value' => $vo->getPermissions()
        ];

        $connection->query(
            $this->updatePermissions(),
            $permissions,
            $id,
        );

        if ($connection->getAffectedRows() === 0) {
            $permissions = [
                "table_name" => 'checklists',
                "table_id" => $id,
                "attribute" => 'permissions',
                "value" => $vo->getPermissions()
            ];

            $connection->query(
                $this->createPermissions(),
                $permissions,
            );
        }

    }

    private function query(): string
    {
        return "
        ";
    }

    private function pairQuestionsWithChecklist(array $questions, string $checklistID, Connection $connection): void
    {
        // Remove old one first
        $connection->query("", $checklistID);

        // Insert new ones
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

    private function updatePermissions(): string
    {
        return "";
    }

    private function createPermissions(): string
    {
        return "";
    }
}

<?php

namespace App\Components\Domain\Case;

use App\Components\Domain\Helpers\JWTHelper;
use App\Components\Domain\ValueObjects\ChecklistValueObject;
use App\Components\Infrastructure\MySQL\Queries\Checklists\AddChecklistQuery;
use App\Components\Infrastructure\MySQL\Queries\Checklists\EditChecklistQuery;
use App\Components\Infrastructure\MySQL\Queries\Checklists\GetAllChecklistsQuery;
use App\Components\Infrastructure\MySQL\Queries\Checklists\GetAnswersForChecklistQuery;
use App\Components\Infrastructure\MySQL\Queries\Checklists\GetChecklistHistoryDetailQuery;
use App\Components\Infrastructure\MySQL\Queries\Checklists\GetChecklistQuery;
use App\Components\Infrastructure\MySQL\Queries\Checklists\GetChecklistQuestionsQuery;
use App\Components\Infrastructure\MySQL\Queries\Checklists\GetChecklistsHistoryQuery;
use App\Components\Infrastructure\MySQL\Queries\Checklists\RemoveChecklistQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\GetSelectedUsersQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\GetUserCompanyDBInformation;
use Dibi\Exception;
use Dibi\Row;

class ChecklistsCase
{
    private Row $companyDBInfo;

    public function __construct(
        private AddChecklistQuery $addChecklistQuery,
        private EditChecklistQuery $editChecklistQuery,
        private GetAllChecklistsQuery $getAllChecklistsQuery,
        private GetChecklistQuery $getChecklistQuery,
        private RemoveChecklistQuery $removeChecklistQuery,
        private GetChecklistsHistoryQuery $getChecklistsHistoryQuery,
        private GetChecklistHistoryDetailQuery $getChecklistHistoryDetailQuery,
        private GetChecklistQuestionsQuery $getChecklistQuestionsQuery,
        private GetSelectedUsersQuery $getSelectedUsersQuery,
        private GetUserCompanyDBInformation $getUserCompanyDBInformation,
        private GetAnswersForChecklistQuery $getAnswersForChecklistQuery,
    ) {
        $this->companyDBInfo = $this->getCompanyDBInfo();
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function getAllChecklists(): ?string
    {
        return $this->getAllChecklistsQuery->execute($this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function removeChecklist(int $id): void
    {
        $this->removeChecklistQuery->execute($id, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function addChecklist(ChecklistValueObject $vo): void
    {
        $this->addChecklistQuery->execute($vo, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function editChecklist(ChecklistValueObject $vo, int $id): void
    {
        $this->editChecklistQuery->execute($vo, $id, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function getChecklist(int $id): ?string
    {
        return $this->getChecklistQuery->execute($id, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function getChecklistQuestions(int $id): ?string
    {
        return $this->getChecklistQuestionsQuery->execute($id, $this->companyDBInfo['dbName']);
    }

    public function getAllHistoryChecklists(): ?string
    {
        $userIds = [];
        $checklistIds = [];

        $checklists = $this->getChecklistsHistoryQuery->execute($this->companyDBInfo['dbName']);

        foreach ($checklists as $checklist) {
            \array_push($userIds, $checklist['user_id']);
            \array_push($checklistIds, $checklist['checklist_record_id']);
        }

        $fetchedUsers = $this->getSelectedUsersQuery->execute($userIds);
        $i = 0;

        foreach ($checklists as $checklist) {
            $checklists[$i]['user_name'] = $fetchedUsers[$checklist['user_id']];
            $i++;
        }

        return \json_encode($checklists);
    }

    public function getSpecificHistoryChecklist(int $id): ?string
    {
        $query = $this->getChecklistHistoryDetailQuery->execute($id, $this->companyDBInfo['dbName']);

        $userName = $this->getSelectedUsersQuery->execute([$query['general_info']['user_id']]);

        $query['general_info']['user_name'] = $userName[$query['general_info']['user_id']];

        return json_encode($query);

    }

    private function getCompanyDBInfo(): Row
    {
        return $this->getUserCompanyDBInformation->execute(JWTHelper::getUserData()['id']);
    }
}


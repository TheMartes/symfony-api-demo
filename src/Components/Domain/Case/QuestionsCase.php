<?php

namespace App\Components\Domain\Case;

use App\Components\Domain\Helpers\JWTHelper;
use App\Components\Domain\ValueObjects\QuestionValueObject;
use App\Components\Infrastructure\MySQL\Queries\Questions\AddQuestionQuery;
use App\Components\Infrastructure\MySQL\Queries\Questions\EditQuestionQuery;
use App\Components\Infrastructure\MySQL\Queries\Questions\GetAllQuestionsQuery;
use App\Components\Infrastructure\MySQL\Queries\Questions\GetQuestionQuery;
use App\Components\Infrastructure\MySQL\Queries\Questions\RemoveQuestionQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\GetUserCompanyDBInformation;
use Dibi\Exception;
use Dibi\Row;

class QuestionsCase
{
    private AddQuestionQuery $addQuestionQuery;
    private EditQuestionQuery $editQuestionQuery;
    private GetAllQuestionsQuery $getAllQuestionsQuery;
    private GetQuestionQuery $getQuestionQuery;
    private RemoveQuestionQuery $removeQuestionQuery;
    private GetUserCompanyDBInformation $getUserCompanyDBInformation;
    private Row $companyDBInfo;

    public function __construct(
        AddQuestionQuery $addQuestionQuery,
        EditQuestionQuery $editQuestionQuery,
        GetAllQuestionsQuery $getAllQuestionsQuery,
        GetQuestionQuery $getQuestionQuery,
        RemoveQuestionQuery $removeQuestionQuery,
        GetUserCompanyDBInformation $getUserCompanyDBInformation,
    )
    {
        $this->addQuestionQuery = $addQuestionQuery;
        $this->editQuestionQuery = $editQuestionQuery;
        $this->getAllQuestionsQuery = $getAllQuestionsQuery;
        $this->getQuestionQuery = $getQuestionQuery;
        $this->removeQuestionQuery = $removeQuestionQuery;
        $this->getUserCompanyDBInformation = $getUserCompanyDBInformation;
        $this->companyDBInfo = $this->getCompanyDBInfo();
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function getAllQuestions(): ?string
    {
        return $this->getAllQuestionsQuery->execute(
            $this->companyDBInfo['id'],
            $this->companyDBInfo['dbName']
        );
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function removeQuestion(int $id): void
    {
        $this->removeQuestionQuery->execute($id, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function addQuestion(QuestionValueObject $vo): void
    {
        $this->addQuestionQuery->execute($vo, $this->companyDBInfo['dbName']);
    }

    /**
     * @throws Exception
     */
    public function editQuestion(QuestionValueObject $vo, int $id): void
    {
        $this->editQuestionQuery->execute($vo, $this->companyDBInfo['dbName'], $id);
    }

    /**
     * @throws Exception
     */
    public function getQuestion(int $id): ?string
    {
        return $this->getQuestionQuery->execute($id, $this->companyDBInfo['dbName']);
    }

    private function getCompanyDBInfo(): Row
    {
        return $this->getUserCompanyDBInformation->execute(JWTHelper::getUserData()['id']);
    }
}

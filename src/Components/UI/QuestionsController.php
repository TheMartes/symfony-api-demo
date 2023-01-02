<?php

namespace App\Components\UI;

use App\Components\App\Questions\Handlers\AddQuestionHandler;
use App\Components\App\Questions\Handlers\EditQuestionHandler;
use App\Components\App\Questions\Handlers\RemoveQuestionHandler;
use App\Components\App\Questions\Handlers\ViewAllQuestionsHandler;
use App\Components\App\Questions\Handlers\ViewQuestionHandler;
use App\Components\Domain\Validators\QuestionsValidator;
use App\Components\Domain\ValueObjects\QuestionValueObject;
use Dibi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionsController extends AbstractController
{
    private AddQuestionHandler $addQuestionHandler;
    private EditQuestionHandler $editQuestionHandler;
    private ViewAllQuestionsHandler $viewAllQuestionsHandler;
    private ViewQuestionHandler $viewQuestionHandler;
    private RemoveQuestionHandler $removeQuestionHandler;

    public function __construct(AddQuestionHandler $addQuestionHandler, EditQuestionHandler $editQuestionHandler, ViewAllQuestionsHandler $viewAllQuestionsHandler, ViewQuestionHandler $viewQuestionHandler, RemoveQuestionHandler $removeQuestionHandler)
    {
        $this->addQuestionHandler = $addQuestionHandler;
        $this->editQuestionHandler = $editQuestionHandler;
        $this->viewAllQuestionsHandler = $viewAllQuestionsHandler;
        $this->viewQuestionHandler = $viewQuestionHandler;
        $this->removeQuestionHandler = $removeQuestionHandler;
    }

    /**
     * @throws Exception
     */
    #[Route('/questions/all', methods: ['GET'])]
    public function getAllQuestions(): Response
    {
        return new Response($this->viewAllQuestionsHandler->execute(), 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/questions/delete/{id}', methods: ['DELETE'])]
    public function deleteQuestion(int $id): Response
    {
        $this->removeQuestionHandler->execute($id);

        return new Response(
            null,
            204
        );
    }

    #[Route('/questions/edit/{id}', methods: ['PUT'])]
    public function editQuestion(int $id, Request $request): Response
    {
        /** @var array<string, string> $payload */
        $payload = json_decode((string) $request->getContent(false), true);
        $validator = new QuestionsValidator($payload);

        if ($validator->validate() === false) {
            return new Response(null, 400);
        }

        $vo = new QuestionValueObject(
            $payload['question_title'],
            $payload['description'],
            $payload['expected_answer'],
            $payload['photo_required'],
            $payload['comment_required'],
            $payload['points'],
            $payload['company'],
            $payload['task_id']
        );

        $this->editQuestionHandler->execute($vo, $id);

        return new Response(null, 200);
    }

    #[Route('/questions/add', methods: ['POST'])]
    public function addQuestion(Request $request): Response
    {
        /** @var array<string, string> $payload */
        $payload = json_decode((string) $request->getContent(false), true);
        $validator = new QuestionsValidator($payload);

        if ($validator->validate() === false) {
            return new Response(null, 400);
        }

        $vo = new QuestionValueObject(
            $payload['question_title'],
            $payload['description'],
            $payload['expected_answer'],
            $payload['photo_required'],
            $payload['comment_required'],
            $payload['points'],
            $payload['company'],
            $payload['task_id']
        );

        $this->addQuestionHandler->execute($vo);

        return new Response(null, 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/questions/{id}', methods: ['GET'])]
    public function viewQuestion(int $id): Response
    {
        $response = $this->viewQuestionHandler->execute($id);

        if ($response === 'null') {
            return new Response(null, 404);
        }

        return new Response($response, 200);
    }
}

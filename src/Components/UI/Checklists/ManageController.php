<?php

namespace App\Components\UI\Checklists;

use App\Components\App\Checklists\Handlers\AddChecklistHandler;
use App\Components\App\Checklists\Handlers\EditChecklistHandler;
use App\Components\App\Checklists\Handlers\RemoveChecklistHandler;
use App\Components\App\Checklists\Handlers\ViewAllChecklistsHandler;
use App\Components\App\Checklists\Handlers\ViewChecklistHandler;
use App\Components\App\Checklists\Handlers\ViewChecklistQuestionsHandler;
use App\Components\Domain\Validators\ChecklistValidator;
use App\Components\Domain\ValueObjects\ChecklistValueObject;
use App\Components\UI\Checklists\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageController extends AbstractController
{
    public function __construct(
        private AddChecklistHandler $addChecklistHandler,
        private EditChecklistHandler $editChecklistHandler,
        private ViewAllChecklistsHandler $viewAllChecklistsHandler,
        private ViewChecklistHandler $viewChecklistHandler,
        private RemoveChecklistHandler $removeChecklistHandler,
        private ViewChecklistQuestionsHandler $viewChecklistQuestionsHandler,
    ) {}

    /**
     * @throws Exception
     */
    #[Route('/checklists/all', methods: ['GET'])]
    public function getAllChecklists(): Response
    {
        return new Response($this->viewAllChecklistsHandler->execute(), 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/checklists/delete/{id}', methods: ['DELETE'])]
    public function deleteChecklist(int $id): Response
    {
        $this->removeChecklistHandler->execute($id);

        return new Response(
            null,
            204
        );
    }

    #[Route('/checklists/edit/{id}', methods: ['PUT'])]
    public function editChecklist(int $id, Request $request): Response
    {
        /** @var array<string, string> $payload */
        $payload = json_decode((string) $request->getContent(false), true);
        $validator = new ChecklistValidator($payload);


        if ($validator->validate() === false) {
            return new Response(null, 400);
        }

        $vo = new ChecklistValueObject(
            $payload['title'],
            $payload['active'] === true ? 1 : 0,
            $payload['interval'],
            $payload['active_days'],
            $payload['time_intervals'],
            $payload['deadline_date'],
            $payload['questions'],
            \json_encode($payload['permissions'])
        );

        $this->editChecklistHandler->execute($vo, $id);

        return new Response(null, 200);
    }

    #[Route('/checklists/add', methods: ['POST'])]
    public function addChecklist(Request $request): Response
    {
        /** @var array<string, string> $payload */
        $payload = json_decode((string) $request->getContent(false), true);
        $validator = new ChecklistValidator($payload);

        if ($validator->validate() === false) {
            return new Response(null, 400);
        }

        $vo = new ChecklistValueObject(
            $payload['title'],
            $payload['active'] === true ? 1 : 0,
            $payload['interval'],
            $payload['active_days'],
            $payload['time_intervals'],
            $payload['deadline_date'],
            $payload['questions'],
            \json_encode($payload['permissions'])
        );

        $this->addChecklistHandler->execute($vo);

        return new Response(null, 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/checklists/{id}', methods: ['GET'])]
    public function viewChecklist(int $id): Response
    {
        $response = $this->viewChecklistHandler->execute($id);

        if ($response === 'null') {
            return new Response(null, 404);
        }

        return new Response($response, 200);
    }

    #[Route('/checklists/questions/{id}', methods: ['GET'])]
    public function getChecklistQuestions(int $id): Response
    {
        $response = $this->viewChecklistQuestionsHandler->execute($id);

        if ($response === 'null') {
            return new Response(null, 404);
        }

        return new Response($response, 200);
    }
}

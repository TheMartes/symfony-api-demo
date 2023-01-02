<?php

namespace App\Components\UI\Tasks;

use App\Components\App\Tasks\Handlers\AddTaskHandler;
use App\Components\App\Tasks\Handlers\EditTaskHandler;
use App\Components\App\Tasks\Handlers\RemoveTaskHandler;
use App\Components\App\Tasks\Handlers\ViewAllTasksHandler;
use App\Components\App\Tasks\Handlers\ViewTaskHandler;
use App\Components\Domain\Helpers\JWTHelper;
use App\Components\Domain\Validators\TasksValidator;
use App\Components\Domain\ValueObjects\TaskValueObject;
use App\Components\UI\Tasks\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ManageController extends AbstractController
{
    private ViewAllTasksHandler $viewAllTasksHandler;
    private RemoveTaskHandler $removeTaskHandler;
    private AddTaskHandler $addTaskHandler;
    private EditTaskHandler $editTaskHandler;
    private ViewTaskHandler $viewTaskHandler;

    public function __construct(
        ViewAllTasksHandler $viewAllTasksHandler,
        RemoveTaskhandler   $removeTaskHandler,
        EditTaskHandler     $editTaskHandler,
        AddTaskHandler      $addTaskHandler,
        ViewTaskHandler     $viewTaskHandler,
    )
    {
        $this->viewAllTasksHandler = $viewAllTasksHandler;
        $this->removeTaskHandler = $removeTaskHandler;
        $this->editTaskHandler = $editTaskHandler;
        $this->addTaskHandler = $addTaskHandler;
        $this->viewTaskHandler = $viewTaskHandler;
    }

    /**
     * @throws Exception
     */
    #[Route('/tasks/all', methods: ['GET'])]
    public function getAllTasks(): Response
    {
        return new Response($this->viewAllTasksHandler->execute(), 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/tasks/delete/{id}', methods: ['DELETE'])]
    public function deleteUser(int $id): Response
    {
        $this->removeTaskHandler->execute($id);

        return new Response(
            null,
            204
        );
    }

    #[Route('/tasks/edit/{id}', methods: ['PUT'])]
    public function editUser(int $id, Request $request): Response
    {
        /** @var array<string, string> $payload */
        $payload = json_decode((string) $request->getContent(false), true);
        $validator = new TasksValidator($payload);


        if ($validator->validate() === false) {
            return new Response(null, 400);
        }

        $vo = new TaskValueObject(
            $payload['task_title'],
            JWTHelper::getUserData()['id'],
            $payload['description'],
            $payload['priority'],
            $payload['due_date_type'],
            $payload['due_date'],
            $payload['photo_required'],
            $payload['comment_required'],
            \json_encode($payload['store_chars'])
        );

        $this->editTaskHandler->execute(
            $vo,
            $id
        );

        return new Response(null, 200);
    }

    #[Route('/tasks/add', methods: ['POST'])]
    public function addUser(Request $request): Response
    {
        /** @var array<string, string> $payload */
        $payload = json_decode((string) $request->getContent(false), true);
        $validator = new TasksValidator($payload);

        if ($validator->validate() === false) {
            return new Response(null, 400);
        }

        $vo = new TaskValueObject(
            $payload['task_title'],
            JWTHelper::getUserData()['id'],
            $payload['description'],
            $payload['priority'],
            $payload['due_date_type'],
            $payload['due_date'],
            $payload['photo_required'],
            $payload['comment_required'],
            \json_encode($payload['store_chars'])
        );

        $this->addTaskHandler->execute($vo);

        return new Response(null, 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/tasks/{id}', methods: ['GET'])]
    public function viewUser(int $id): Response
    {
        $response = $this->viewTaskHandler->execute($id);

        if ($response === 'null') {
            return new Response(null, 404);
        }

        return new Response($response, 200);
    }
}

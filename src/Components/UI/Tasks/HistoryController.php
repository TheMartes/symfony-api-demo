<?php

namespace App\Components\UI\Tasks;

use App\Components\App\Tasks\Handlers\PostHistoryComment;
use App\Components\App\Tasks\Handlers\PostHistoryCommentHandler;
use App\Components\App\Tasks\Handlers\ViewAllHistoryTasksHandler;
use App\Components\App\Tasks\Handlers\ViewSpecificHistoryTaskHandler;
use App\Components\Domain\ValueObjects\PostHistoryCommentValueObject;
use App\Components\UI\Tasks\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    public function __construct(
        private ViewAllHistoryTasksHandler $viewAllHistoryTasksHandler,
        private ViewSpecificHistoryTaskHandler $viewSpecificHistoryTaskHandler,
        private PostHistoryCommentHandler $postHistoryCommentHandler,
    )
    {}

    /**
     * @throws Exception
     */
    #[Route('/tasks/history/all', methods: ['GET'])]
    public function getAllHistoryTasks(): Response
    {
        return new Response($this->viewAllHistoryTasksHandler->execute(), 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/tasks/history/{id}', methods: ['GET'])]
    public function getSingleHistoryTask(int $id): Response
    {
        return new Response($this->viewSpecificHistoryTaskHandler->execute($id), 200);
    }

    #[Route('/tasks/history/comment/add/{id}', methods: ['POST'])]
    public function postHistoryComment(Request $request, int $id): Response
    {
        /** @var array<string, string> $payload */
        $payload = json_decode((string) $request->getContent(false), true);

        if ($payload['comment'] === null) {
            return new Response(null, 400);
        }

        $vo = new PostHistoryCommentValueObject(
            $payload['comment'],
        );

        $this->postHistoryCommentHandler->execute(
            $vo,
            $id
        );

        return new Response(null, 200);

    }
}

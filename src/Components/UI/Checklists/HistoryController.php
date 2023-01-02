<?php

namespace App\Components\UI\Checklists;

use App\Components\App\Checklists\Handlers\ViewChecklistsHistoryDetailHandler;
use App\Components\App\Checklists\Handlers\ViewChecklistsHistoryHandler;
use App\Components\UI\Checklists\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HistoryController extends AbstractController
{
    public function __construct(
        private ViewChecklistsHistoryDetailHandler $viewChecklistsHistoryDetailHandler,
        private ViewChecklistsHistoryHandler $viewChecklistsHistoryHandler,
    )
    {}

    /**
     * @throws Exception
     */
    #[Route('/checklists/history/all', methods: ['GET'])]
    public function getAllHistoryChecklists(): Response
    {
        return new Response($this->viewChecklistsHistoryHandler->execute(), 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/checklists/history/{id}', methods: ['GET'])]
    public function getSingleHistoryChecklist(int $id): Response
    {
        return new Response($this->viewChecklistsHistoryDetailHandler->execute($id), 200);
    }
}

<?php

namespace App\Components\UI;

use App\Components\App\Stores\Handlers\AddStoreHandler;
use App\Components\App\Stores\Handlers\EditStoreHandler;
use App\Components\App\Stores\Handlers\GetAllCharsHandler;
use App\Components\App\Stores\Handlers\RemoveStoreHandler;
use App\Components\App\Stores\Handlers\ViewAllStoresHandler;
use App\Components\App\Stores\Handlers\ViewStoreHandler;
use App\Components\Domain\Validators\StoreValidator;
use App\Components\Domain\ValueObjects\StoreValueObject;
use App\Components\UI\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoresController extends AbstractController
{
    public function __construct(
        private ViewAllStoresHandler $viewAllStoresHandler,
        private RemoveStoreHandler $removeStoreHandler,
        private EditStoreHandler $editStoreHandler,
        private AddStoreHandler $addStoreHandler,
        private ViewStoreHandler $viewStoreHandler,
        private GetAllCharsHandler $getAllCharsHandler
    ) {}
    /**
     * @throws Exception
     */
    #[Route('/stores/all', methods: ['GET'])]
    public function getAllStores(): Response
    {
        return new Response($this->viewAllStoresHandler->execute(), 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/stores/delete/{id}', methods: ['DELETE'])]
    public function deleteUser(int $id): Response
    {
        $this->removeStoreHandler->execute($id);

        return new Response(
            null,
            204
        );
    }

    #[Route('/stores/edit/{id}', methods: ['PUT'])]
    public function editStore(int $id, Request $request): Response
    {
        /** @var array<string, string|array> $payload */
        $payload = json_decode((string) $request->getContent(false), true);
        $validator = new StoreValidator($payload);


        if ($validator->validate() === false) {
            return new Response(null, 400);
        }

        $vo = new StoreValueObject(
            $payload['store_name'],
            $payload['store_code'],
            $payload['active'],
            $payload['attributes'],
            $payload['opening_date'],
            $payload['closing_date'],
        );

        $this->editStoreHandler->execute(
            $vo,
            $id
        );

        return new Response(null, 200);
    }

    #[Route('/stores/add', methods: ['POST'])]
    public function addStore(Request $request): Response
    {
        /** @var array<string, string|array> $payload */
        $payload = json_decode((string) $request->getContent(false), true);
        $validator = new StoreValidator($payload);

        if ($validator->validate() === false) {
            return new Response(null, 400);
        }

        $vo = new StoreValueObject(
            $payload['store_name'],
            $payload['store_code'],
            $payload['active'],
            $payload['attributes'],
            $payload['opening_date'],
            $payload['closing_date'],
        );

        $this->addStoreHandler->execute(
            $vo
        );

        return new Response(null, 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/stores/{id}', methods: ['GET'])]
    public function viewStore(int $id): Response
    {
        $response = $this->viewStoreHandler->execute($id);

        if ($response === 'null') {
            return new Response(null, 404);
        }

        return new Response($response, 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/stores/chars/all', methods: ['GET'])]
    public function getChars(): Response
    {
        $response = $this->getAllCharsHandler->execute();

        return new Response($response, 200);
    }
}

<?php

namespace App\Components\UI;

use App\Components\App\Users\Handlers\AddUserHandler;
use App\Components\App\Users\Handlers\EditUserHandler;
use App\Components\App\Users\Handlers\RemoveUserHandler;
use App\Components\App\Users\Handlers\ViewAllUsersHandler;
use App\Components\App\Users\Handlers\ViewAllUsersPresetsHandler;
use App\Components\App\Users\Handlers\ViewAllUsersRolesHandler;
use App\Components\App\Users\Handlers\ViewUserHandler;
use App\Components\Domain\Helpers\JWTHelper;
use App\Components\Domain\Validators\UserValidator;
use App\Components\Domain\ValueObjects\UserValueObject;
use Dibi\Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UsersController extends AbstractController
{
    private ViewAllUsersHandler $viewAllUsersHandler;
    private RemoveUserHandler $removeUserHandler;
    private AddUserHandler $addUserHandler;
    private EditUserHandler $editUserHandler;
    private ViewUserHandler $viewUserHandler;

    public function __construct(
        ViewAllUsersHandler $viewAllUsersHandler,
        RemoveUserHandler   $removeUserHandler,
        EditUserHandler     $editUserHandler,
        AddUserHandler      $addUserHandler,
        ViewUserHandler     $viewUserHandler,
        private ViewAllUsersRolesHandler $viewAllUsersRolesHandler,
        private ViewAllUsersPresetsHandler $viewAllUsersPresetsHandler
    )
    {
        $this->viewAllUsersHandler = $viewAllUsersHandler;
        $this->removeUserHandler = $removeUserHandler;
        $this->editUserHandler = $editUserHandler;
        $this->addUserHandler = $addUserHandler;
        $this->viewUserHandler = $viewUserHandler;
    }

    /**
     * @throws Exception
     */
    #[Route('/users/all', methods: ['GET'])]
    public function getAllUsers(): Response
    {
        $userData = JWTHelper::getUserData();
        return new Response($this->viewAllUsersHandler->execute($userData['id']), 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/users/roles/all', methods: ['GET'])]
    public function getAllUserRoles(): Response
    {
        $userData = JWTHelper::getUserData();
        return new Response($this->viewAllUsersRolesHandler->execute(), 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/users/presets/all', methods: ['GET'])]
    public function getAllUserPresets(): Response
    {
        $userData = JWTHelper::getUserData();
        return new Response($this->viewAllUsersPresetsHandler->execute(), 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/users/delete/{id}', methods: ['DELETE'])]
    public function deleteUser(int $id): Response
    {
        $this->removeUserHandler->execute($id);

        return new Response(
            null,
            204
        );
    }

    #[Route('/users/edit/{id}', methods: ['PUT'])]
    public function editUser(int $id, Request $request): Response
    {
        /** @var array<string, string> $payload */
        $payload = json_decode((string) $request->getContent(false), true);
        $validator = new UserValidator($payload);


        if ($validator->validate() === false) {
            return new Response(null, 400);
        }

        $vo = new UserValueObject(
            $payload['name'],
            $payload['email'],
            $payload['lang'],
            $payload['role'],
            (isset($payload['password'])) ? $payload['password'] : null,
            $payload['preset'],
            $payload['active'],
        );

        $this->editUserHandler->execute(
            $vo->getName(),
            $vo->getEmail(),
            $vo->getLang(),
            $vo->getRole(),
            $vo->getPreset(),
            $vo->getActive(),
            $id,
            $vo->getPassword()
        );

        return new Response(null, 200);
    }

    #[Route('/users/add', methods: ['POST'])]
    public function addUser(Request $request): Response
    {
        /** @var array<string, string> $payload */
        $payload = json_decode((string) $request->getContent(false), true);
        $validator = new UserValidator($payload);

        if ($validator->validate() === false) {
            return new Response(null, 400);
        }

        $vo = new UserValueObject(
            $payload['name'],
            $payload['email'],
            $payload['lang'],
            $payload['role'],
            $payload['password'],
            $payload['preset'],
            $payload['active'],
        );

        $this->addUserHandler->execute(
            $vo->getName(),
            $vo->getEmail(),
            $vo->getLang(),
            $vo->getRole(),
            $vo->getPassword(),
            $vo->getPreset(),
            $vo->getActive()
        );

        return new Response(null, 200);
    }

    /**
     * @throws Exception
     */
    #[Route('/users/{id}', methods: ['GET'])]
    public function viewUser(int $id): Response
    {
        $response = $this->viewUserHandler->execute($id);

        if ($response === 'null') {
            return new Response(null, 404);
        }

        return new Response($response, 200);
    }
}

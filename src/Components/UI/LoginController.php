<?php

namespace App\Components\UI;

use App\Components\App\Login\Handlers\LoginHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LoginController extends AbstractController
{
    public LoginHandler $loginHandler;

    public function __construct(LoginHandler $loginHandler)
    {
        $this->loginHandler = $loginHandler;
    }

    #[Route('/login', methods: ['POST'])]
    public function login(Request $request): Response
    {
        /** @var array<string, string> $payload */
        $payload = json_decode((string) $request->getContent(false), true);

        $response = $this->loginHandler->execute($payload);

        return new JsonResponse($response, 200);
    }
}

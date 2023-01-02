<?php

namespace App\EventSubscribers;

use App\Components\Domain\Helpers\JWTHelper;
use Exception;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class RequestSubscriber implements EventSubscriberInterface
{
    private const LOGIN_PATH = '/login';

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onRequest'
        ];
    }

    /**
     * @throws \Exception
     */
    public function onRequest(RequestEvent $event): void
    {
        JWT::$leeway = 5;
        $reqPath = Request::createFromGlobals()->getPathInfo();

        if ($reqPath !== self::LOGIN_PATH) {
            try {
                JWTHelper::checkJWTSignature();
            } catch (ExpiredException $error) {
                $event->setResponse(new Response(null, 401));
            }
        }
    }
}

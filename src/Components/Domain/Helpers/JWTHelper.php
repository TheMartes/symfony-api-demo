<?php

namespace App\Components\Domain\Helpers;

use App\Components\Domain\ValueObjects\JWTValueObject;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Symfony\Component\HttpFoundation\Request;

class JWTHelper
{
    private CONST JWT_SECRET = 'supersecretKey';
    private CONST AUTHORIZATION_HEADER = 'authorization';
    private CONST BEARER_PREFIX = 'Bearer ';

    /** @var array<string, string|int|array<string, string|int>> */
    private static array $token = [];

    /**
     * @param array<string, string|int> $userData
     * @throws \Exception
     */
    public static function generateToken(array $userData, bool $remember): string
    {
        $tokenData = self::generateTokenData($userData, $remember);
        try {
           $token = JWT::encode($tokenData->toArray(), self::JWT_SECRET, 'HS256');
        } catch (\Exception $e) {
            throw new $e;
        }

        return $token;
    }

    public static function checkJWTSignature(): void
    {
        $token = self::getTokenFromRequest();

        self::$token = (array) JWT::decode($token, new Key(self::JWT_SECRET, 'HS256'));
    }

    public static function getTokenFromRequest(): string
    {
        $req = Request::createFromGlobals();
        $token = $req->headers->get(self::AUTHORIZATION_HEADER);

        return str_replace(self::BEARER_PREFIX, '', (string) $token);
    }

    /**
     * @return array<string, string|int|array<string, string|int>>
     */
    public static function getRequestToken(): array
    {
        return self::$token;
    }

    /**
     * @return array<string, int|string>
     */
    public static function getUserData(): array
    {
        return (array) self::$token['user-data'];
    }

    /**
     * @param array<string, string|int> $userData
     */
    private static function generateTokenData(array $userData, bool $remember): JWTValueObject
    {
        $requestMetadata = self::getRequestMetadata();

        return new JWTValueObject(
            $requestMetadata['server'],
            $requestMetadata['client'],
            self::generateIssuedAt(),
            self::generateExpiration($remember),
            $userData
        );
    }

    /**
     * @return array<string, string>
     */
    private static function getRequestMetadata(): array
    {
        $req = Request::createFromGlobals();

        return [
            'server' => $req->getHttpHost(),
            'client' => $req->server->get("HTTP_ORIGIN")
        ];
    }

    private static function generateIssuedAt(): int
    {
        return Carbon::now()->timestamp;
    }

    private static function generateExpiration(bool $remember): int
    {
        if ($remember) {
            return Carbon::now()->addDays(30)->timestamp;
        }

        return Carbon::now()->addDay()->timestamp;
    }
}

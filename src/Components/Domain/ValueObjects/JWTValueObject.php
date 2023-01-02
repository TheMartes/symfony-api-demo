<?php

namespace App\Components\Domain\ValueObjects;

class JWTValueObject
{
    private string $iss;
    private string $aud;
    private int $iat;
    private int $exp;

    private const ISS_KEY = 'iss';
    private const AUD_KEY = 'aud';
    private const IAT_KEY = 'iat';
    private const EXP_KEY = 'exp';
    private const USERDATA_KEY = 'user-data';

    /** @var array<string, string|int> $userData */
    private array $userData;

    /**
     * @param string $iss Issuer
     * @param string $aud Audience
     * @param int $iat Issued At
     * @param int $nbf Not Before (expiration)
     * @param array<string, string|int> $userData
     */
    public function __construct(string $iss, string $aud, int $iat, int $exp, array $userData)
    {
        $this->iss = $iss;
        $this->aud = $aud;
        $this->iat = $iat;
        $this->exp = $exp;
        $this->userData = $userData;
    }

    /**
     * @return string
     */
    public function getIss(): string
    {
        return $this->iss;
    }

    /**
     * @return string
     */
    public function getAud(): string
    {
        return $this->aud;
    }

    /**
     * @return int
     */
    public function getIat(): int
    {
        return $this->iat;
    }

    /**
     * @return int
     */
    public function getExp(): int
    {
        return $this->exp;
    }

    /**
     * @return array<string, string|int>
     */
    public function getUserData(): array
    {
        return $this->userData;
    }

    /**
     * @return array<string, array<string, string|int>|int|string>
     */
    public function toArray(): array
    {
        return [
            self::ISS_KEY => $this->iss,
            self::AUD_KEY => $this->aud,
            self::IAT_KEY => $this->iat,
            self::EXP_KEY => $this->exp,
            self::USERDATA_KEY => $this->userData
        ];
    }
}

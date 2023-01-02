<?php

namespace App\Components\Infrastructure\MySQL\Entity;

class ConfigurationEntity
{
    public static function getConfiguration(?string $customDatabase = null): array
    {
        return [
            'driver'   => 'mysqli',
            'host'     => $_ENV['DATABASE_HOST'],
            'username' => $_ENV['DATABASE_USER'],
            'password' => $_ENV['DATABASE_PASSWORD'],
            'database' => $customDatabase ?? $_ENV['DATABASE_NAME'],
        ];
    }
}

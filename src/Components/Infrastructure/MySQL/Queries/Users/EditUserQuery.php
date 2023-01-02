<?php

namespace App\Components\Infrastructure\MySQL\Queries\Users;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use Dibi\Connection;
use Dibi\Exception;

class EditUserQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(string $name,
        string $email,
        string $lang,
        string $role,
        string $preset,
        int $active,
        int $userId,
        ?string $password
    ): void
    {
        if ($this->singleton->getConnection() === null) {
            throw new Exception(DBErrorEnum::ConnectionNotOpened->name);
        }

        $connection = $this->singleton->getConnection();

        $args = [
            'name' => $name,
            'email' => $email,
            'active' => $active
        ];

        if ($password !== null && $password !== "") {
            $args['password'] = $password;
        }

        $userSettings = [
            'role' => $role,
            'lang' => $lang,
            'preset' => $preset,
        ];

        $connection->query($this->updateQuery(), $args, $userId);
        $this->setSettings($userId, $userSettings, $connection);
    }

    private function updateQuery(): string
    {
        return "
        ";
    }

    private function setSettings(int $id, array $settings, Connection $connection): void
    {
        foreach ($settings as $k => $v) {
            $connection->query(
            );
        }
    }
}

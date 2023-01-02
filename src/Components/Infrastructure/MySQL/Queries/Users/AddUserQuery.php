<?php

namespace App\Components\Infrastructure\MySQL\Queries\Users;

use App\Components\Infrastructure\MySQL\Enums\DBErrorEnum;
use App\Components\Infrastructure\MySQL\Queries\Query;
use Dibi\Connection;
use Dibi\Exception;

class AddUserQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(string $name, string $email, string $lang, string $role, string $password, string $preset, $active): void
    {
        if ($this->singleton->getConnection() === null) {
            throw new Exception(DBErrorEnum::ConnectionNotOpened->name);
        }

        $connection = $this->singleton->getConnection();

        $args = [
            'name' => $name,
            'password' => $password,
            'email' => $email,
            'active' => $active
        ];

        $userSettings = [
            'role' => $role,
            'lang' => $lang,
            'preset' => $preset,
        ];

        $connection->query($this->insertQuery(), $args);
        $id = $connection->getInsertId();

        $this->setSettings($id, $userSettings, $connection);
        $this->pairToCompany($id, $connection);
    }

    private function insertQuery(): string
    {
        return "";
    }

    private function setSettings(int $id, array $settings, Connection $connection): void
    {
        foreach ($settings as $k => $v) {
            $connection->query();
        }
    }

    private function pairToCompany(int $id, Connection $connection)
    {
        $args = [ 'company_id' => 3, 'user_id' => $id ];
        $connection->query("", $args);
    }
}

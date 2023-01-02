<?php

namespace App\Components\Domain\Case;

use App\Components\Infrastructure\MySQL\Queries\Users\AddUserQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\EditUserQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\GetAllPresetsQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\GetAllRolesQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\GetAllUsersQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\GetUserQuery;
use App\Components\Infrastructure\MySQL\Queries\Users\RemoveUserQuery;
use Dibi\Exception;

class UsersCase
{
    public GetAllUsersQuery $getAllUsersQuery;
    public RemoveUserQuery $removeUserQuery;
    public GetUserQuery $getUserQuery;
    public EditUserQuery $editUserQuery;
    public AddUserQuery$addUserQuery;

    public function __construct(
        GetAllUsersQuery $getAllUsersQuery,
        RemoveUserQuery $removeUserQuery,
        AddUserQuery $addUserQuery,
        EditUserQuery $editUserQuery,
        GetUserQuery $getUserQuery,
        private GetAllRolesQuery $getAllRolesQuery,
        private GetAllPresetsQuery $getAllPresetsQuery
    )
    {
        $this->getAllUsersQuery = $getAllUsersQuery;
        $this->removeUserQuery = $removeUserQuery;
        $this->addUserQuery = $addUserQuery;
        $this->editUserQuery = $editUserQuery;
        $this->getUserQuery = $getUserQuery;
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function getAllUsers(int $idUser): ?string
    {
        return $this->getAllUsersQuery->execute($idUser);
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function getAllRoles(): ?string
    {
        return $this->getAllRolesQuery->execute();
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function getAllPresets(): ?string
    {
        return $this->getAllPresetsQuery->execute();
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function removeUser(int $id): void
    {
        $this->removeUserQuery->execute($id);
    }

    /**
     * @throws Exception
     */
    public function addUser(string $name, string $email, string $lang, string $role, string $password, string $preset, string $active): void
    {
        $this->addUserQuery->execute($name, $email, $lang, $role, $password, $preset, $active);
    }

    /**
     * @throws Exception
     */
    public function editUser(string $name, string $email, string $lang, string $role, string $preset, string $active, int $userId, ?string $password): void
    {
        $this->editUserQuery->execute($name, $email, $lang, $role, $preset, $active, $userId, $password);
    }

    /**
     * @throws Exception
     */
    public function getUser(int $id): ?string
    {
        return $this->getUserQuery->execute($id);
    }
}

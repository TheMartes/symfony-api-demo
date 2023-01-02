<?php

namespace App\Components\App\Users\Handlers;

use App\Components\Domain\Case\UsersCase;
use Dibi\Exception;

class RemoveUserHandler
{
    private UsersCase $case;

    public function __construct(
        UsersCase $case,
    )
    {
        $this->case = $case;
    }

    /**
     * @throws Exception
     */
    public function execute(int $id): void
    {
        $this->case->removeUser($id);
    }
}

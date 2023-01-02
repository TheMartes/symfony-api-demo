<?php

namespace App\Components\App\Users\Handlers;

use App\Components\Domain\Case\UsersCase;
use Dibi\Exception;

class ViewUserHandler
{
    public UsersCase $case;

    public function __construct(
        UsersCase $case,
    )
    {
        $this->case = $case;
    }

    /**
     * @throws Exception
     */
    public function execute(int $id): ?string
    {
        return $this->case->getUser($id);
    }
}

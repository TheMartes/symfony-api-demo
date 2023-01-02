<?php

namespace App\Components\Infrastructure\MySQL\Queries;

use App\Components\Infrastructure\MySQL\ConnectionSingleton;
use Dibi\Exception;

abstract class Query
{
    public ConnectionSingleton $singleton;

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function __construct(ConnectionSingleton $mysql)
    {
        $this->singleton = $mysql;

        if ($this->singleton->getConnection() === null) {
            $this->singleton->openConnection();
        }
    }

    /**
     * @throws \Exception
     */
    public function __destruct()
    {
        if ($this->singleton->getConnection() !== null) {
            $this->singleton->closeConnection();
        }
    }
}

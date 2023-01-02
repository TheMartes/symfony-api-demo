<?php

namespace App\Components\Infrastructure\MySQL;

use App\Components\Infrastructure\MySQL\Entity\ConfigurationEntity;
use Dibi\Connection;
use Dibi\Exception;

class ConnectionSingleton
{
    private ConfigurationEntity $configuration;
    private ?Connection $connection;

    public function __construct(ConfigurationEntity $configuration)
    {
        $this->configuration = $configuration;
        $this->connection = null;
    }

    /**
     * @throws Exception
     * @throws \Exception
     */
    public function openConnection(): void
    {
        if ($this->connection !== null) {
            throw new \Exception('Connection already opened');
        }

        try {
            $connection = new Connection($this->configuration::getConfiguration());
        } catch (\Exception $exception) {
            throw new Exception($exception->getMessage(), $exception->getCode());
        }

        $this->connection = $connection;
    }

    /**
     * @throws \Exception
     */
    public function getConnection(): ?Connection
    {
        return $this->connection;
    }

    /**
     * @throws \Exception
     */
    public function closeConnection(): void
    {
        if ($this->connection === null) {
            throw new \Exception('Connection not opened');
        }

        $this->connection->disconnect();
        $this->connection = null;
    }
}

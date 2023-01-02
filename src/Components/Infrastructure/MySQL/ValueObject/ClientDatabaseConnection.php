<?php

namespace App\Components\Infrastructure\MySQL\ValueObject;

use App\Components\Infrastructure\MySQL\Entity\ConfigurationEntity;
use Dibi\Connection;

class ClientDatabaseConnection
{
    private ?Connection $connection;
    private ConfigurationEntity $configuration;
    private string $dbName;

    public function __construct(string $databaseName)
    {
        $this->configuration = new ConfigurationEntity();
        $this->connection = null;
        $this->dbName = $databaseName;
    }

    public function __destruct()
    {
        $this->closeConnection();
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
            $connection = new Connection($this->configuration::getConfiguration($this->dbName));
        } catch (\Exception $exception) {
            throw new \Exception($exception->getMessage(), $exception->getCode());
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

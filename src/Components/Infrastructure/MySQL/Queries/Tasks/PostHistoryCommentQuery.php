<?php

namespace App\Components\Infrastructure\MySQL\Queries\Tasks;

use App\Components\Domain\ValueObjects\PostHistoryCommentValueObject;
use App\Components\Infrastructure\MySQL\Queries\Query;
use App\Components\Infrastructure\MySQL\ValueObject\ClientDatabaseConnection;
use dibi;
use Dibi\Exception;

class PostHistoryCommentQuery extends Query
{
    /**
     * @throws Exception
     * @throws \Exception
     */
    public function execute(PostHistoryCommentValueObject $vo, int $userId, int $commentId, string $clientDBName): array
    {
        $connectionValueObject = new ClientDatabaseConnection($clientDBName);

        $connection = $connectionValueObject->openConnection();
        $connection = $connectionValueObject->getConnection();

        $data = [
            "tasks_record_id" => $commentId,
            "created_at" => $connection->literal('NOW()'),
            "synced_at" => $connection->literal('NOW()'),
            "message" => $vo->getComment(),
            "user_id" => $userId
        ];

        $query = $connection->query($this->query(), $data);

        return $query->fetchAll();
    }

    private function query(): string
    {
        return "";
    }
}


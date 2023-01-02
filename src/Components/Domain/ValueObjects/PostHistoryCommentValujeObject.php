<?php

namespace App\Components\Domain\ValueObjects;

class PostHistoryCommentValueObject
{
    private string $comment;

    /**
     * @param string $comment
     */
    public function __construct(string $comment)
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }
}

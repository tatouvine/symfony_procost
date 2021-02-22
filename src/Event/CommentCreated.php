<?php

declare(strict_types=1);

namespace App\Event;

use App\Entity\Src\Store\Comment;

final class  CommentCreated
{
    private Comment $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    public function getComment(): Comment
    {
        return $this->comment;
    }
}

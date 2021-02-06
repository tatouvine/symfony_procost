<?php

namespace App\Manager;

use App\Entity\Src\Store\Comment;
use Doctrine\ORM\EntityManagerInterface;

class CommentManager
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function save(Comment $comment): void
    {
        $this->em->persist($comment);
        $this->em->flush();
    }
}

<?php

namespace App\Manager;

use App\Entity\Src\Store\Comment;
use App\Event\CommentCreated;
use App\Event\ContactCreated;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class CommentManager
{

    private EntityManagerInterface $em;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $em,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }


    public function save(Comment $comment): void
    {
        $this->em->persist($comment);
        $this->em->flush();
        $this->eventDispatcher->dispatch(new CommentCreated($comment));
    }
}

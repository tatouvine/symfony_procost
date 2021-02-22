<?php

namespace App\Manager;

use App\Entity\Src\Contact;
use App\Event\ContactCreated;
use App\Service\ContactMailer;
use Doctrine\ORM\EntityManagerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;

class ContactManager
{

    private EntityManagerInterface $em;
    private EventDispatcherInterface $eventDispatcher;

    public function __construct(EntityManagerInterface $em,
                                EventDispatcherInterface $eventDispatcher)
    {
        $this->em = $em;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function save(Contact $contact): void
    {
        $this->em->persist($contact);
        $this->em->flush();
        $this->eventDispatcher->dispatch(new ContactCreated($contact));
    }
}

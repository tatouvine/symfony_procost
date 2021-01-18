<?php

namespace App\Manager;

use App\Entity\Src\Contact;
use App\Service\ContactMailer;
use Doctrine\ORM\EntityManagerInterface;

class ContactManager
{

    private EntityManagerInterface $em;
    private ContactMailer $contactMailer;

    public function __construct(EntityManagerInterface $em, ContactMailer $contactMailer)
    {
        $this->em = $em;
        $this->contactMailer = $contactMailer;
    }

    public function save(Contact $contact): void
    {
        $this->em->persist($contact);
        $this->em->flush();

        $this->contactMailer->send($contact);
    }
}
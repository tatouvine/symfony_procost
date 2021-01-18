<?php

namespace App\Service;

use App\Entity\Src\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Twig\Environment;

class ContactMailer
{
    private $mailer;
    private $contactEmailAddress;
    private $twig;

    public function __construct(MailerInterface $mailer, Environment $twig, string $contactEmailAddress)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->contactEmailAddress = $contactEmailAddress;
    }

    public function send(Contact $contact): void
    {
        $email = (new Email())
            ->from($contact->getEmail())
            ->to($this->contactEmailAddress)
            ->subject("Un message de contact sur Shoefony")
            ->html($this->twig->render('email/contact.html.twig', ['contact' => $contact]));

        $this->mailer->send($email);
    }
}

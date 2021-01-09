<?php

namespace App\Service;

use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class ContactMailler
{
    public function __construct(MailerInterface $mailer, Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public function send(Contact $contact): void
    {
        $email = new Email();
        $email->setBody($this->twig->render(self::TEMPLATE,['contact' =>$contact]));
    }
}

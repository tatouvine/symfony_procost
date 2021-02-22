<?php

namespace App\Event\Subscriber;

use App\Event\ContactCreated;
use App\Service\ContactMailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class ContactSubscriber implements EventSubscriberInterface
{
    private ContactMailer $contactMailer;

    public function __construct(ContactMailer $contactMailer)
    {
        $this->contactMailer = $contactMailer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContactCreated::class => [
                ['sendEmail'],
            ],
        ];
    }

    public function sendEmail(ContactCreated $event): void
    {
        $this->contactMailer->send($event->getContact());
    }

}

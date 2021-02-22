<?php

namespace App\Event\Subscriber;

use App\Event\CommentCreated;
use App\Event\ContactCreated;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

final class FlashSubscriber implements EventSubscriberInterface
{
    private FlashBagInterface $flashBag;

    public function __construct(FlashBagInterface $flashBag)
    {
        $this->flashBag = $flashBag;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ContactCreated::class => [
                ['addContactCreatedFlash', -100],
            ],
            CommentCreated::class => [
                ['addCommentCreatedFlash', -100],
            ],
        ];
    }

    public function addContactCreatedFlash(ContactCreated $event): void
    {
        $this->addSuccessFlash('Merci, votre message a été pris en compte!');
    }

    public function addCommentCreatedFlash(CommentCreated $event): void
    {
        $user = $event->getComment()->getUser();
        if ($user === null) {
            throw new  \LogicException('The user should not be null at this step');
        }
        $this->addSuccessFlash(sprintf('Merci %s , votre commentaire a bien été pris en compte !', $user->getUsername()));

    }

    private function addSuccessFlash(string $message): void
    {
        $this->flashBag->add('success', $message);
    }

}

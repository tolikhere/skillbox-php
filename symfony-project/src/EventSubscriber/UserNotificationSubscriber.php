<?php

namespace App\EventSubscriber;

use App\Events\UserRegisteredEvent;
use App\Service\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserNotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Mailer $mailer
    ) {
    }
    public function onUserRegisteredEvent(UserRegisteredEvent $event): void
    {
        $this->mailer->sendWelcomeMessage($event->getUser());
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserRegisteredEvent::class => 'onUserRegisteredEvent',
        ];
    }
}

<?php

namespace App\EventSubscriber;

use App\Entity\User;
use App\Events\ArticleCreatedEvent;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class AdminNotificationSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private Mailer $mailer,
        private string $adminEmail,
        private UserRepository $userRepository
    ) {
    }
    public function onArticleCreatedEvent(ArticleCreatedEvent $event): void
    {
        $article = $event->getArticle();

        $isAdmin = \in_array(User::ROLE_ADMIN, $article->getAuthor()->getRoles());

        if (! $isAdmin) {
            $this->mailer->sendAdminNotification(
                $this->userRepository->findOneBy(['email' => $this->adminEmail]),
                $article
            );
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ArticleCreatedEvent::class => 'onArticleCreatedEvent',
        ];
    }
}

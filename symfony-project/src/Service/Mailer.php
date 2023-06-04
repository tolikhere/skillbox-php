<?php

namespace App\Service;

use App\Entity\Article;
use App\Entity\User;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    public function sendWelcomeMessage(User $user)
    {
        $email = $this->createHtmlEmailTemplate(
            $user,
            'email/welcome.html.twig',
            'Добро пожаловать на Spill-Coffee-On-The-Keyboard!'
        );

        $this->mailer->send($email);
    }

    public function sendWeeklyNewsLetter(User $user, array $articles)
    {
        $email = $this->createHtmlEmailTemplate(
            $user,
            'email/newsletter.html.twig',
            'Еженедельная рассылка статей Spill-Coffee-On-The-Keyboard'
        )->context([
                'articles'       => $articles,
                'title'          => 'Еженедельная рассылка',
                'isWeeklyReport' => true,
            ])
        ->attach('Опубликовано статей на сайте: ' . count($articles), 'report_' . date('Y-m-d') . '.txt')
        ;

        $this->mailer->send($email);
    }

    public function createHtmlEmailTemplate(User $user, string $template, string $subject): TemplatedEmail
    {
        $email = (new TemplatedEmail())
            ->from(new Address('noreply@symfony.skillbox', 'Spill-Coffee-On-The-Keyboard'))
            ->to(new Address($user->getEmail(), $user->getFirstName()))
            ->subject($subject)
            ->htmlTemplate($template)
        ;
        return $email;
    }

    public function sendAdminStatisticReport($file, \DateTime $dateFrom, \DateTime $dateTo, $email)
    {
        $email = (new Email())
            ->from(new Address('noreply@symfony.skillbox', 'Spill-Coffee-On-The-Keyboard'))
            ->to($email)
            ->subject('Report')
            ->text('Отчет ' . $dateFrom->format('d.m.Y') . ' - ' . $dateTo->format('d.m.Y'))
            ->attach($file, 'report.csv')
        ;

        $this->mailer->send($email);
    }

    public function sendAdminNotification(User $user, Article $article): void
    {
        $email = $this->createHtmlEmailTemplate(
            $user,
            'email/newsletter.html.twig',
            'Создана новая статья Spill-Coffee-On-The-Keyboard'
        )->context([
            'articles'       => [$article],
            'title'          => 'Создана новая статья',
            'isWeeklyReport' => false
        ]);

        $this->mailer->send($email);
    }
}

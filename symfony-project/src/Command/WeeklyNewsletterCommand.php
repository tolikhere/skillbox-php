<?php

namespace App\Command;

use App\Entity\Article;
use App\Entity\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use App\Service\Mailer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:weekly-newsletter',
    description: 'Еженедельная рассылка статей',
)]
class WeeklyNewsletterCommand extends Command
{
    public function __construct(
        private UserRepository $userRepository,
        private ArticleRepository $articleRepository,
        private Mailer $mailer
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        /** @var User[] $users */
        $users = $this->userRepository->findAllActiveUsers();

        /** @var Article[] $articles */
        $articles = $this->articleRepository->findAllPublishedLastWeek();

        if (count($articles) === 0) {
            $io->warning('За последнюю неделю никто не публиковал статьи');
            return Command::SUCCESS;
        }

        $io->progressStart(count($users));

        foreach ($users as $user) {
            $io->progressAdvance();
            $this->mailer->sendWeeklyNewsletter($user, $articles);
        }

        $io->progressFinish();

        $io->success('Еженедельная рассылка была отправлена активным пользователям!');

        return Command::SUCCESS;
    }
}

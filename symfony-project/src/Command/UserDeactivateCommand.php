<?php

namespace App\Command;

use App\Repository\UserRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:user:deactivate',
    description: 'Deactivate a user by given id or activate by given option "--reverse"',
)]
class UserDeactivateCommand extends Command
{
    public function __construct(private UserRepository $userRepository)
    {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Deactivate a user by id')
            ->addOption('reverse', null, InputOption::VALUE_NONE, 'Activate a user')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $id = (int) $input->getArgument('id');
        $isActive = false;

        if ($input->getOption('reverse')) {
            $isActive = true;
        }
        $user = $this->userRepository->find($id);

        if (! $user) {
            $io->error('There is no user with such ID.');
            return Command::FAILURE;
        }

        $user->setIsActive($isActive);
        $this->userRepository->save($user, true);

        $io->success("A user with the id {$id} is " . ($isActive ? 'activated' : 'deactivated') . '.');

        return Command::SUCCESS;
    }
}

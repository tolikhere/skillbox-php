<?php

namespace App\Command;

use App\Entity\Article;
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
use Symfony\Component\Filesystem\Filesystem;

#[AsCommand(
    name: 'app:admin-statistic-report',
    description: 'Генерирует в указанный период *.csv*-файл с отчётом и отправляет на указанный *email*',
)]
class AdminStatisticReportCommand extends Command
{
    private array $rawData = [];

    public function __construct(
        private ArticleRepository $articleRepository,
        private UserRepository $userRepository,
        private Mailer $mailer,
    ) {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('email', InputArgument::OPTIONAL, 'Email получателя')
            ->addOption('dateFrom', null, InputOption::VALUE_OPTIONAL, 'Дата начала периода; по умолчанию — "–1 неделя"', '-1 week')
            ->addOption('dateTo', null, InputOption::VALUE_OPTIONAL, 'Дата окончания периода; по умолчанию — "сегодня"', 'now')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $this->rawData = [
            'email'    => $input->getArgument('email'),
            'dateFrom' => $input->getOption('dateFrom'),
            'dateTo'   => $input->getOption('dateTo'),
        ];

        $email = \filter_var($this->rawData['email'], FILTER_VALIDATE_EMAIL);
        $dateFrom = \date_create($this->rawData['dateFrom']);
        $dateTo = \date_create($this->rawData['dateTo']);

        // Checking on any bad data from a user
        if (! $email || ! $dateFrom || ! $dateTo) {
            $this->setErrors($io, $email, $dateFrom, $dateTo);

            return Command::FAILURE;
        }

        // Creating a temporary file
        $tmpFileName = (new Filesystem())->tempnam(sys_get_temp_dir(), 'sb_');
        $tmpFile = fopen($tmpFileName, 'wb+');
        if (!\is_resource($tmpFile)) {
            throw new \RuntimeException('Не удалось создать временный файл.');
        }

        // generating csv data in an array
        $data = $this->createCsvData($dateFrom, $dateTo);

        // writing data into $tmpFile in a csv format
        foreach ($data as $line) {
            fwrite($tmpFile, '|');
            fputcsv($tmpFile, $line, '|', eol: '|' . PHP_EOL);
        }

        $this->mailer->sendAdminStatisticReport($tmpFile, $dateFrom, $dateTo, $email);

        fclose($tmpFile);

        return Command::SUCCESS;
    }

    private function setErrors(SymfonyStyle $io, $email, $dateFrom, $dateTo): void
    {
        if (! $email) {
            $io->note(sprintf('Ваш email: %s', $this->rawData['email']));
            $io->error('Требуется валидный email!');
        }

        if (! $dateFrom || ! $dateTo) {
            $io->note(sprintf('Неправильный формат даты: %s', $this->rawData[(! $dateFrom) ? 'dateFrom' : 'dateTo']));
            $io->error('Требуется валидная дата');
        }
    }

    private function createCsvData(\DateTime $dateFrom, \DateTime $dateTo): array
    {
        $articlesCount = $this->articleRepository->countArticlesInDateRange($dateFrom, $dateTo);
        $articlesPublishedCount  = $this->articleRepository->countArticlesInDateRange($dateFrom, $dateTo, true);
        $usersCount = $this->userRepository->countAllUsers();

        return [
            ['Период', 'Всего пользователей', 'Статей создано за период', 'Статей опубликовано за период',],
            [
                $dateFrom->format('d.m.Y') . ' - ' . $dateTo->format('d.m.Y'),
                $usersCount,
                $articlesCount,
                $articlesPublishedCount,
            ],
        ];
    }
}

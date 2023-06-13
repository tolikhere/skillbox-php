<?php

namespace SymfonySkillbox\HomeworkBundle\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Helper\TableStyle;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use SymfonySkillbox\HomeworkBundle\UnitFactory;
use SymfonySkillbox\HomeworkBundle\Unit;

#[AsCommand(
    name: 'symfony-skillbox-homework:produce-units',
    description: 'The command to start the unit creation factory.',
)]
class SymfonySkillboxHomeworkProduceUnitsCommand extends Command
{
    public function __construct(
        private UnitFactory $unitFactory
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument('resources', InputArgument::REQUIRED, 'Argument description');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $resources = $input->getArgument('resources');

        if (!is_numeric($resources)) {
            $io->error('The resources argument must be a number!');
            return Command::FAILURE;
        }
        $units = $this->unitFactory->produceUnits((int) $resources);

        // Rendering table
        $io->writeln("На {$resources} было куплено " . \count($units) . " юнитов");
        $this->renderTable($units, $output);
        $io->writeln(
            "Осталось ресурсов: {$this->getLeftResources((int) $resources, $units)}"
        );

        return Command::SUCCESS;
    }

    /**
     * @param Unit[] $units
     * @param OutputInterface $output
     * @return void
     */
    private function renderTable(array $units, OutputInterface $output): void
    {
        $table = new Table($output);
        $tableStyle = new TableStyle();

        // customizes the style
        $tableStyle
            ->setHorizontalBorderChars('-')
            ->setVerticalBorderChars('')
            ->setDefaultCrossingChar(' ')
        ;

        /** @param Unit $unit */
        $table
            ->setHeaders(['Имя', 'Цена', 'Сила', 'Ловкость', 'Здоровье'])
            ->setRows(
                \array_map(function ($unit) {
                    return [
                        $unit->getName(),
                        $unit->getCost(),
                        $unit->getStrength(),
                        $unit->getAgility(),
                        $unit->getHealth(),
                    ];
                }, $units)
            )
            ->setStyle($tableStyle)
            ->render()
        ;
    }

    /**
     * @param int $resources
     * @param Unit[] $units
     * @return int
     */
    private function getLeftResources(int $resources, array $units): int
    {
        /** @param Unit $unit */
        return $resources - \array_reduce(
            $units,
            fn ($sum, $unit) => $sum + $unit->getCost()
        );
    }
}

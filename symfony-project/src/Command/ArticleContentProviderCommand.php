<?php

namespace App\Command;

use App\Homework\ArticleContentProvider;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:article:content-provider',
    description: 'Generates article content with markdown syntax',
)]
class ArticleContentProviderCommand extends Command
{
    public function __construct(
        private ArticleContentProvider $articleContentProvider
    ) {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('paragraphs', InputArgument::REQUIRED, 'The amount of paragraphs')
            ->addArgument('word', InputArgument::OPTIONAL, 'A word that you want to be in content', null)
            ->addArgument('words_count', InputArgument::OPTIONAL, 'How many words?', 0);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $paragraphs = $input->getArgument('paragraphs');
        $word = $input->getArgument('word');
        $wordsCount = $input->getArgument('words_count');
        // check if paragraphs and wordsCount are numeric values
        if (! is_numeric($paragraphs)) {
            throw new \Exception('<paragraphs> MUST be an integer');
        } elseif (! is_numeric($wordsCount)) {
            throw new \Exception('<words_count> MUST be an integer');
        }

        $content = $this->articleContentProvider->get($paragraphs, $word, $wordsCount);

        $io->write($content);

        $io->success('Success!');

        return Command::SUCCESS;
    }
}

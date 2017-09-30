<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Formatter\OutputFormatterStyle;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class GreeterCommand extends Command
{

    public function configure()
    {
        $this->setName('greeter')
             ->setDescription('It greets or says goodbye to a person by name.');

    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        // Ask a Question
        $name = $io->ask("What is your name?");
        $output->writeln($name);

        // Table
        $rows = [
            ['Alice', 'black'],
            ['Erica', 'green'],
            ['Roberta', 'orange']
        ];
        $io->table(['name', 'favourite colour'], $rows);

        // Progress Bar
        $io->writeln('Starting processing...');
        $number = 10;
        $progressBar = new ProgressBar($output, $number);
        $progressBar->start();

        for ($i = 0; $i < $number; $i++) {
            // processing happens here
            sleep(1);
            $progressBar->advance();
        }

        $progressBar->finish();
        $io->writeln('');
        $io->writeln('Finished processing...');

        return 0;
    }
}

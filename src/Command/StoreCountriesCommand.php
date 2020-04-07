<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class StoreCountriesCommand extends Command
{
    protected static $defaultName = 'store-countries';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('filepath', InputArgument::OPTIONAL, 'path to the file containing the countries')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filepath = $input->getArgument('filepath');

        if ($filepath) {
            $content = file_get_contents($filepath);
            $io->note(sprintf('You passed an argument: %s', $filepath));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}

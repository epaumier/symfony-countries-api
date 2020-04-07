<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Country;

class StoreCountriesCommand extends Command
{
    protected static $defaultName = 'store-countries';

    public $em;

    public function __construct(EntityManagerInterface $em)
    {
        parent::__construct();
        $this->em = $em;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('filepath', InputArgument::OPTIONAL, 'path to the file containing the countries')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $filepath = $input->getArgument('filepath');

        if ($filepath) {
            //turn the content of the file into an array
            $countries = file($filepath);
            
            foreach ($countries as $country) {
                //avoid short, irrelevant lines (first and last one)
                if (strlen($country) < 5) {
                    continue;
                }

                //Time for a little cleaning. Start by removing whitespaces on each side
                $country = trim($country);

                //remove that pesky comma on the right
                $country = rtrim($country, ',');

                //json loves double quotes, replace single with doubles
                $country = str_replace('\'', '"', $country);

                //In order to add double quotes to our future keys (name and code), we
                //search for them and replace them accordingly.
                $country = str_replace('code:', '"code":', $country);
                $country = str_replace('name:', '"name":', $country);
                
                //turning the string into an object, for inserting into entity
                $country = json_decode($country);
                
                //after creating new entity, insert data
                $newCountry = new Country();
                $newCountry->setName($country->name);
                $newCountry->setCode($country->code);
                
                //insert data into database
                $this->em->persist($newCountry);
                $this->em->flush();
            }

            $io->note(sprintf('You have succesfully inserted new countries into the DB'));
        }

        $io->success('Success ! Please browse to /country in order to view results');

        return 0;
    }
}

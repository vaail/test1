<?php

namespace AppBundle\Command;

use DateTime;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetWeekNumber extends Command
{
    protected function configure()
    {
        $this
            ->setName('app:get-week-number')
            ->setDescription('Retrieve week number of the date')
            ->setHelp('This command retrieve week number of the date')
            ->addArgument('date', InputArgument::REQUIRED, 'Date (YYYY-MM-DD)');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $date = $input->getArgument('date');
        $weekNumber = $this->getWeekNumber($date);
        $output->writeln(sprintf('%s on a %d week', $date, $weekNumber));
    }

    private function getWeekNumber(string $date): int
    {
        try {
            $dt = new DateTime($date);
        } catch (Exception $e) {
            throw new Exception('Invalid date format. Use following format: YYYY-MM-DD');
        }

        $isPre = $dt->format('n') < 9;
        $initialYear = $isPre ? $dt->format('Y') - 1 : ($dt->format('Y'));
        $initialWeek = new DateTime($initialYear . '-09-01');

        $dateDiff = $initialWeek->diff($dt);

        $dayOfWeek = $initialWeek->format('w');
        $dayOfWeek = $dayOfWeek == 0 ? 7 : $dayOfWeek - 1;

        $wk = $dateDiff->format('%a') + $dayOfWeek;
        $weekNumber = ($wk / 7) % 4 + 1;

        return $weekNumber;
    }
}
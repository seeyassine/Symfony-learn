<?php

namespace App\Command;

use App\Service\Math;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'math:add',
    description: 'Add to values and displays the result',
)]
class MathAddCommand extends Command
{
    public function __construct(private Math $math, )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
          ->addArgument('a',InputArgument::REQUIRED,'the a value')
            ->addArgument('b',InputArgument::REQUIRED,'the b value')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $a = $input->getArgument('a');
        $b = $input->getArgument('b');

        $io->success($this->math->add($a,$b));

        return Command::SUCCESS;
    }
}

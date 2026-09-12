<?php

namespace App\Command;

use App\Entity\Memo;
use App\Repository\MemoRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'app:fixtures:load', description: 'Loads sample memos into DynamoDB.')]
class LoadFixturesCommand extends Command
{
    public function __construct(
        private readonly MemoRepository $memoRepository,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $memo = new Memo();
        $memo->setTitle('aaa');
        $memo->setDescription('bb');

        $this->memoRepository->save($memo);

        (new SymfonyStyle($input, $output))->success('Loaded 1 memo.');

        return Command::SUCCESS;
    }
}

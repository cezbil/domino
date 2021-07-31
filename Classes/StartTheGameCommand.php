<?php


namespace DominoGame;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

class StartTheGameCommand extends Command
{

    protected function configure(): void
    {
        $this->setName('domino-start')
            ->setDescription('<comment>starts new game</comment>')
            ->setHelp('This command starts the game...')
            ->addArgument(
                'player-names',
                InputArgument::IS_ARRAY | InputArgument::REQUIRED,
                '<comment>enter names for the players [./startTheGame domino-start "Cezary" "Ralph"]</comment>.'
            );    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $playerNames = $input->getArgument('player-names');
        if (count($playerNames) < 2){
            $output->writeln('<error>at least 2 players to play</error>');
            Command::FAILURE;
        } else {
            $this->initGame($playerNames);
            $output->writeln('<info>new game starts</info>');

        }

        return Command::SUCCESS;
    }

    private function initGame(array $playerNames) {
        $game = new Game();
        $game->start($playerNames);

        return $game;
    }
}
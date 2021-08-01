<?php


namespace DominoGame;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;

/**
 * Class StartTheGameCommand
 *
 * @package DominoGame
 */
class StartTheGameCommand extends Command
{

    /**
     *
     */
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

    /**
     * @param  InputInterface  $input
     * @param  OutputInterface  $output
     *
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $playerNames = $input->getArgument('player-names');
        if (count($playerNames) < 2 || count($playerNames) > 4){
            $output->writeln('<error>2 players min 4 players max</error>');
            Command::FAILURE;
        } else {
            $game = $this->initGame($playerNames, $output);
        }
        return Command::SUCCESS;
    }

    /**
     * @param  array  $playerNames
     * @param  OutputInterface  $output
     *
     * @return Game
     */
    private function initGame(array $playerNames, OutputInterface $output) : Game {
        $game = new Game($output);
        $game->start($playerNames);

        return $game;
    }
}
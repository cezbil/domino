<?php


namespace DominoGame;

use Symfony\Component\Console\Output\OutputInterface;

require 'Classes/DominoTile.php';

/**
 * Class Game
 *
 * @package DominoGame
 */
class Game
{

    /**
     * @var DominoTile[]
     */
    private $dominoTiles = [];

    /**
     * @var int
     */
    private $numberOfPlayers = 0;

    /**
     * @var bool
     */
    private $gameWon = false;

    /**
     * @var Player[]
     */
    private $players = [];

    /**
     * @var OutputInterface
     */
    private $output;

    /**
     * Game constructor.
     *
     * @param  OutputInterface  $output
     */
    public function __construct(OutputInterface $output)
    {
        $this->output = $output;
    }

    /**
     * @param  array  $names
     */
    public function start(array $names)
    {
        $this->output->writeln('<info>new game starts</info>');

        $deck = new DominosTilesDeck();
        $board = new Board();

        $this->playersInception($names, $deck);
        $this->printPlayersHand();
        $this->printPiecesLeft($deck);

        $startTile = $this->makeStart($board);
        $this->run($board, $deck);
    }

    /**
     * @param  array  $names
     * @param  DominosTilesDeck  $deck
     */
    public function playersInception(array $names, DominosTilesDeck $deck)
    {
        foreach ($names as $name) {
            $player = new Player($name);
            array_push($this->players, $player);
            $tilesInHand = $deck->createHandForPlayer($player);
        }
    }

    /**
     *
     */
    public function printPlayersHand() {
        foreach ($this->players as $player) {
            $this->output->writeln('<info>' . $player->printName() . ' ' . $player->handToString() . PHP_EOL . '</info>');
        }
    }

    /**
     * @param  DominosTilesDeck  $deck
     */
    public function printPiecesLeft(DominosTilesDeck $deck) {
        $this->output->writeln(PHP_EOL . $deck->toString() . '</comment>');
    }

    /**
     * @param  Board  $board
     * @param  DominosTilesDeck  $dominosTilesDeck
     */
    public function run(Board $board, DominosTilesDeck $dominosTilesDeck)
    {
        $rounds = 0;
        while (!$this->gameWon) {
            $rounds++;
            if ($rounds !== 1) {
                $currentPlayer = $this->nextPlayer();
            } else {
                $currentPlayer = $this->players[0];

            }
            $dominoTilesReadyToPlay = $currentPlayer->getPlayableTilesForPlayer($board->getEnds());

            if (count($dominoTilesReadyToPlay) > 0) {
                $selectedDomino = reset($dominoTilesReadyToPlay);
                $currentPlayer->removeDominoByScore($selectedDomino->getScore());
                $addSelected = $board->matchesDominoTile($selectedDomino);
                $this->output->writeln(PHP_EOL .'<comment>' . $currentPlayer->printName() . ' plays' . $addSelected->toString(). '</comment>');
                $this->output->writeln(PHP_EOL .'<info>'  . 'Current state of the board' . $board->toString() . '</info>');
            } else {
                if ($dominosTilesDeck->sizeOfTheDeck() !== 0){
                    $this->output->writeln(PHP_EOL .'<comment> ' . $currentPlayer->printName() . ' picks another domino' . '</comment>');
                    $dominosTilesDeck->dealToPlayer($currentPlayer); // take a piece
                }
            }
            $this->endGame($currentPlayer, $dominosTilesDeck, $dominoTilesReadyToPlay);
        }
    }

    /**
     * @param  Board  $board
     *
     * @return DominoTile
     */
    private function makeRandomStart(Board $board) : DominoTile
    {
        $player = $this->players[0];
        $rTile = rand(0, DominosTilesDeck::CARDS_IN_HAND - 1);
        $tile = $player->removeTilebyIndex($rTile);

        $board->addStartTile($tile);

        return $tile;
    }

    /**
     * @param  Player  $currentPlayer
     * @param  DominosTilesDeck  $dominosTilesDeck
     * @param $dominoTilesReadyToPlay
     */
    private function endGame(
        Player $currentPlayer,
        DominosTilesDeck $dominosTilesDeck,
        $dominoTilesReadyToPlay
    )
    {
        // if we run out of the dominos
        if ($currentPlayer->sizeOfTheHand() === 0) {
            $this->gameWon = true;
            $this->output->writeln(PHP_EOL .'<comment> ' . $currentPlayer->printName() . ' wins' . '</comment>');
        } else if ($dominosTilesDeck->sizeOfTheDeck() === 0 &&
            $currentPlayer->sizeOfTheHand() !== 0 &&
            count($dominoTilesReadyToPlay) === 0) {
            $keyForPlayer = 0;
            $totalDots = 1000;
            foreach ($this->players as $key=>$player) {
                if ($totalDots > $player->getTotalDots()) {
                    $keyForPlayer = $key;
                    $totalDots = $player->getTotalDots();
                }
            }
            $this->gameWon = true;
            $this->printPlayersHand();
            $this->output->writeln(PHP_EOL .'<comment> ' . $this->players[$keyForPlayer]->printName() . ' wins because had least dots left' . '</comment>');
        }
    }

    /**
     * @param  Board  $board
     *
     * @return DominoTile
     */
    private function makeStart(Board $board) : DominoTile
    {
        $player = $this->pickPlayerWithHighestDouble();
        $key = array_search($player->getName(), array_column($this->players, 'name'));
        array_unshift($this->players, $player);
        unset($this->players[$key + 1]);
        $this->output->writeln(PHP_EOL .'<comment>' . $player->printName() . ' will start' . '</comment>');


        $rTile = rand(0, DominosTilesDeck::CARDS_IN_HAND - 1);
        $tile = $player->removeTilebyIndex($rTile);

        $board->addStartTile($tile);

        return $tile;
    }

    /**
     * @return Player
     */
    private function pickPlayerWithHighestDouble()
    {
        $score = 0;
        $keyToRetrievePlayer = 0;
        foreach ($this->players as $key=>$player) {
            if ($player->getBiggestDouble()) {
                if ($score < $player->getBiggestDouble()->getScore()){
                    $keyToRetrievePlayer = $key;
                    $score = $player->getBiggestDouble()->getScore();
                }
            }
        }
        return $this->players[$keyToRetrievePlayer];
    }

    /**
     * @return Player
     */
    private function nextPlayer() : Player
    {
        array_push( $this->players, array_shift($this->players));
        return $this->players[0];
    }


}
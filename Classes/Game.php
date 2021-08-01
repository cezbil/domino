<?php


namespace DominoGame;

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

    private $numberOfPlayers = 0;

    /**
     * @var Player[]
     */
    private $players = [];

    /**
     * Game constructor.
     *
     */
    public function __construct()
    {
    }

    public function start(array $names)
    {
        $deck = new DominosTilesDeck();
        $board = new Board();

        $this->playersInception($names, $deck);
        $this->printPlayersHand();
        $this->printPiecesLeft($deck);
        /* Choose a random member and card to start the fight. */
        $startTile = $this->makeRandomStart($board);
        print_r($board->toString());
        /* Runs the loop until the game ends. */
        $this->run($board, $deck);
    }

    public function playersInception(array $names, DominosTilesDeck $deck)
    {
        foreach ($names as $name) {
            $player = new Player($name);
            array_push($this->players, $player);
            $tilesInHand = $deck->createHandForPlayer($player);
        }
    }
    public function printPlayersHand() {
        foreach ($this->players as $player) {
            print_r($player->printName() . ' ' . $player->handToString() . PHP_EOL);
        }
    }
    public function printPiecesLeft(DominosTilesDeck $deck) {
        print_r($deck->toString());
    }
    public function run(Board $board, DominosTilesDeck $dominosTilesDeck)
    {
        $rounds = 1;
        while (true) {
            $rounds++;
            $currentPlayer = $this->nextPlayer();
            $dominoTilesReadyToPlay = $currentPlayer->getPlayableTilesForPlayer($board->getEnds());

            if (count($dominoTilesReadyToPlay) > 0) {
                $selectedDomino = reset($dominoTilesReadyToPlay);
                $currentPlayer->removeDominoByScore($selectedDomino->getScore());
                $addSelected = $board->matchesDominoTile($selectedDomino);
                print_r(PHP_EOL . $currentPlayer->printName() . ' plays' . $addSelected->toString());
                print_r(PHP_EOL . ' current state of the board' . $board->toString());

            }
        }
    }

    private function makeRandomStart(Board $board) : DominoTile
    {
        $player = $this->players[0];
        $rTile = rand(0, DominosTilesDeck::CARDS_IN_HAND - 1);
        $tile = $player->removeTilebyIndex($rTile);

        $board->addStartTile($tile);

        return $tile;
    }
    private function nextPlayer() : Player
    {
        array_push( $this->players, array_shift($this->players));
        return $this->players[0];
    }


}
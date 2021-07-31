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
        $this->playersInception($names, $deck);
    }

    public function playersInception(array $names, DominosTilesDeck $deck)
    {
        foreach ($names as $name) {
            $player = new Player($name);
            array_push($this->players, $player);
            $tilesInHand = $deck->createHandForPlayer($player);
        }
    }
}
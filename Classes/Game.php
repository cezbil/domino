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
    private $dominoTiles;

    private $numberOfPlayers;

    /**
     * Game constructor.
     *
     */
    public function __construct()
    {
    }

    public function createDominoTiles() {
        $score = 0;
        for ($i = 0; $i <= 6; $i++) {
            for ($n = $i; $n <= 6; $n++) {
                $score++;
                $tile = new DominoTile($i, $n, $score);
                $this->dominoTiles[] = $tile;
            }
        }

        shuffle($this->dominoTiles);
    }
}
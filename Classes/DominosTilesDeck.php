<?php


namespace DominoGame;


/**
 * Class DominosTilesDeck
 *
 * @package DominoGame
 */
class DominosTilesDeck
{
    /**
     *
     */
    const CARDS_IN_HAND = 7;
    /**
     * @var DominoTile[]
     */
    private $dominoTiles;

    /**
     * DominosTilesDeck constructor.
     *
     */
    public function __construct()
    {
        $score = 0;
        for ($i = 0; $i <= 6; $i++) {
            for ($n = $i; $n <= 6; $n++) {
                $score++;
                $tile = new DominoTile($i, $n, $score);
                $this->dominoTiles[] = $tile;
            }
        }
        $this->shuffleTiles();
    }

    /**
     * @return $this
     */
    public function shuffleTiles() : DominosTilesDeck
    {
        shuffle($this->dominoTiles);
        return $this;
    }

    /**
     * @return int
     */
    public function sizeOfTheDeck() : int
    {
        return count($this->dominoTiles);
    }

    /**
     * @return DominoTile|null
     */
    public function removeTile() : ?DominoTile
    {
        //return tile simultaneously removing it from the deck
        return array_pop($this->dominoTiles);
    }

    /**
     * @param  Player  $player
     */
    public function dealToPlayer(Player $player)
    {
        $player->addNewTile($this->removeTile());
    }

    /**
     * @param  Player  $player
     *
     * @return string
     */
    public function createHandForPlayer(Player $player)
    {
        for ($i = 0; $i < DominosTilesDeck::CARDS_IN_HAND; $i++) {
            $this->dealToPlayer($player);
        }
        return $player->handToString();
    }
    /**
     * @return string
     */
    public function toString() : string
    {
        $map = array_map(function (DominoTile $dominoTile) {
            return $dominoTile->toString();
        }, $this->dominoTiles);
        return join('-', $map);
    }
}
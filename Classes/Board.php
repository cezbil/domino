<?php


namespace DominoGame;


/**
 * Class Board
 *
 * @package DominoGame
 */
class Board
{
    /**
     * @var DominoTile[]
     */
    private $dominoTiles = [];
    /**
     * @var array
     */
    private $ends;

    /**
     * @param  DominoTile  $dominoTile
     */
    public function matchesDominoTile(DominoTile $dominoTile)
    {
        if ($dominoTile->getHead() === $this->ends[1]){
            return 'right';
        } else if ($dominoTile->getTail() === $this->ends[0]) {
            return 'left';
        } else if ($dominoTile->getHead() === $this->ends[0]) {
            $dominoTile->turn();
            return 'left';
        } else if ($dominoTile->getTail() === $this->ends[1]) {
            $dominoTile->turn();
            return 'right';
        } else {
            return false;
        }
    }

    /**
     * @return array
     */
    public function createEnds()
    {
        $this->ends = [reset($this->dominoTiles)->getHead(), end($this->dominoTiles)->getTail()];
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

    public function addStartTile(DominoTile $tile) : void
    {
        array_unshift($this->dominoTiles, $tile);
        $this->createEnds();
    }

}
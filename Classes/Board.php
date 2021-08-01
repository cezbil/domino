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
     * @return DominoTile[]
     */
    public function getDominoTiles(): array
    {
        return $this->dominoTiles;
    }

    /**
     * @param  DominoTile[]  $dominoTiles
     */
    public function setDominoTiles(array $dominoTiles): void
    {
        $this->dominoTiles = $dominoTiles;
    }

    /**
     * @return array
     */
    public function getEnds(): array
    {
        return $this->ends;
    }

    /**
     * @param  array  $ends
     */
    public function setEnds(array $ends): void
    {
        $this->ends = $ends;
    }

    /**
     * @param  DominoTile  $dominoTile
     */
    public function matchesDominoTile(DominoTile $dominoTile)
    {
        if ($dominoTile->getHead() === $this->ends[1]){
            $this->addEndTile($dominoTile);
            return end($this->dominoTiles);
        } else if ($dominoTile->getTail() === $this->ends[0]) {
            $this->addStartTile($dominoTile);
            return $this->dominoTiles[0];
        } else if (!$dominoTile->isFlip()) {
            $dominoTile->flip();
            return $this->matchesDominoTile($dominoTile);
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

    /**
     * @param  DominoTile  $tile
     */
    public function addStartTile(DominoTile $tile) : void
    {
        array_unshift($this->dominoTiles, $tile);
        $this->createEnds();
    }

    /**
     * @param  DominoTile  $tile
     */
    public function addEndTile(DominoTile $tile) : void
    {
        array_push($this->dominoTiles, $tile);
        $this->createEnds();
    }

}
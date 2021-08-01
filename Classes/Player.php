<?php


namespace DominoGame;


class Player
{
    /**
     * @var string
     */
    public $name;

    /**
     * @var DominoTile[]
     */
    private $dominoTiles = [];

    /**
     * Player constructor.
     *
     * @param  string  $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
    /**
     * @return string
     */
    public function printName(): string
    {
        return 'Player:' . $this->name;
    }

    /**
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

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
    public function setDominoTiles(array $dominoTiles)
    {
        $this->dominoTiles = $dominoTiles;
    }

    public function addNewTile(?DominoTile $dominoTile)
    {
        array_push($this->dominoTiles, $dominoTile);
    }

    public function handToString() : string
    {
        $map = array_map(function (DominoTile $dominoTile) {
            return $dominoTile->toString();
        }, $this->dominoTiles);
        return join('-', $map);
    }
    public function removeTilebyIndex(int $index): DominoTile
    {
        $tileToReturn = $this->dominoTiles[$index];
        unset($this->dominoTiles[$index]);
        return $tileToReturn;
    }
    public function removeDominoByScore(int $score)
    {
        array_walk($this->dominoTiles, function (?DominoTile $domino, $key) use ($score) {
            if ($domino) {
                if ($domino->getScore() === $score) {
                    unset($this->dominoTiles[$key]);
                }
            }
        });
    }
    public function getPlayableTilesForPlayer(array $sides)
    {
       return array_filter($this->dominoTiles, function (?DominoTile $domino) use ($sides) {
            if (!is_null($domino) &&
                ($this->checkIfMatch($domino->getHead(), $sides) ||
                $this->checkIfMatch($domino->getTail(), $sides))
            ) {
                return $domino;
            }
        });
    }
    public function checkIfMatch($dominoSide, $boardSides)
    {
        return in_array($dominoSide, $boardSides);
    }
    public function getDoubles()
    {
        return array_filter($this->dominoTiles, function (DominoTile $domino)  {
            return $domino->isDouble();
        });
    }
    public function getBiggestDouble()
    {
        $doubles = $this->getDoubles();
        return empty($doubles) ? false : max($doubles);
    }
    public function getTotalDots()
    {
        $total = 0;
        foreach ($this->dominoTiles as $dominoTile) {
            $total += $dominoTile->getHead() + $dominoTile->getTail();
        }
        return $total;
    }
    public function sizeOfTheHand() : int
    {
        return count($this->dominoTiles);
    }
}
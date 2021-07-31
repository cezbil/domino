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

    public function addNewTile(DominoTile $dominoTile)
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
    public function getBiggerDouble() {
        if (empty($this->dominoTiles)) {
            return 0;
        }

        $sameSides = array_filter($this->dominoTiles,
            function (DominoTile $tile) {
                return $tile->sameSides();
            }
        );

        if (empty($sameSides)) {
            return [];
        }

        $maxSameSide = reset($sameSides);
        $max = $maxSameSide->getHeads();

        foreach ($sameSides as $sameSidePiece) {
            if ($sameSidePiece->getHeads() > $max) {
                $maxSameSide = $sameSidePiece;
                $max = $sameSidePiece->getHeads();
            }
        }

        return $maxSameSide;
    }
    public function removeTilebyIndex(int $index): DominoTile
    {
        $tileToReturn = $this->dominoTiles[$index];
        unset($this->dominoTiles[$index]);
        return $tileToReturn;
    }
}
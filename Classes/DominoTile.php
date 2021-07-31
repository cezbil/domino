<?php

namespace DominoGame;

/**
 * class for domino
 */
class DominoTile
{
    /**
     * @var int
     */
    private $head;
    /**
     * @var int
     */
    private $tail;
    /**
     * @var int
     */
    private $score;

    /**
     * Domino constructor.
     *
     * @param  int  $head
     * @param  int  $tail
     * @param  int  $score
     */
    public function __construct(int $head, int $tail, int $score)
    {
        $this->head = $head;
        $this->tail = $tail;
        $this->score = $score;
    }


    public function toString() : string
    {
        return '[' . $this->head . ',' . $this->tail . ']';
    }
}
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

    /**
     * @return int
     */
    public function getHead(): int
    {
        return $this->head;
    }

    /**
     * @param  int  $head
     */
    public function setHead(int $head): void
    {
        $this->head = $head;
    }

    /**
     * @return int
     */
    public function getTail(): int
    {
        return $this->tail;
    }

    /**
     * @param  int  $tail
     */
    public function setTail(int $tail): void
    {
        $this->tail = $tail;
    }

    /**
     * @return int
     */
    public function getScore(): int
    {
        return $this->score;
    }

    /**
     * @param  int  $score
     */
    public function setScore(int $score): void
    {
        $this->score = $score;
    }
}
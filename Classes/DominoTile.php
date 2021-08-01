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
     * @var bool
     */
    private $flip;

    /**
     * @return bool
     */
    public function isFlip(): bool
    {
        return $this->flip;
    }

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
        $this->flip = false;
    }


    /**
     * @return string
     */
    public function toString() : string
    {
        return '[' . $this->getHead() . ',' . $this->getTail() . ']';
    }

    /**
     * @return int
     */
    public function getHead(): int
    {
        return !$this->isFlip() ? $this->head : $this->tail;

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
        return !$this->isFlip() ? $this->tail : $this->head;
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

    /**
     * @return bool
     */
    public function sameSides() {
        return $this->head === $this->tail;
    }

    public function flip() {
        $this->flip = true;
    }
    public function isDouble() {
        return $this->getHead() == $this->getTail();
    }
}
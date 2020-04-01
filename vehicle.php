<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 01.04.2020
 * Time: 12:37
 */

class Vehicle
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var string
     */
    private $direction;

    /**
     * @var int
     */
    private $speed;

    /**
     * Vehicle constructor.
     *
     * @param int    $position
     * @param string $direction
     * @param int    $speed
     */
    public function __construct(int $position, string $direction = 'left', int $speed = 1)
    {
        $this->position  = $position;
        $this->direction = $direction;
        $this->speed     = $speed;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @return string
     */
    public function getDirection(): string
    {
        return $this->direction;
    }

    /**
     * @return int
     */
    public function getSpeed(): int
    {
        return $this->speed;
    }

}
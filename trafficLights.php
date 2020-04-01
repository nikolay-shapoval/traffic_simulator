<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 01.04.2020
 * Time: 12:37
 */

class TrafficLights
{
    /**
     * @var int
     */
    private $position;

    /**
     * @var int
     */
    private $time;

    /**
     * @var int
     */
    private $firstIsGreen;

    /**
     * TrafficLights constructor.
     *
     * @param      $position
     * @param      $time
     * @param bool $firstIsGreen
     */
    public function __construct(int $position, int $time, $firstIsGreen = true)
    {
        $this->position     = $position;
        $this->time         = $time;
        $this->firstIsGreen = $firstIsGreen;
    }

    /**
     * @return int
     */
    public function getPosition(): int
    {
        return $this->position;
    }

    /**
     * @param $position
     *
     * @return bool
     */
    public function isTrafficLightsGreen($position): bool
    {
        if ((floor($position / $this->time) % 2) == 0) {
            if ($this->firstIsGreen) {
                return true;
            }
        } else {
            if (!$this->firstIsGreen) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $position
     *
     * @return bool
     */
    public function isOnTrafficLights($position): bool
    {
        return $position >= $this->position
            && $position < ($this->position + $this->time);
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 01.04.2020
 * Time: 8:41
 */

$simulator = new trafficSimulator();
$simulator->render();

/**
 * Class trafficSimulator
 */
class trafficSimulator
{
    /**
     * @var int
     */
    private $trafficLightsPosition;

    /**
     * @var int
     */
    private $trafficLightsTime;

    /**
     * @var array
     */
    private $vehicles;

    /**
     * @var bool
     */
    private $firstIsGreenLight;

    /**
     * @var int
     */
    private $duration = 0;

    /**
     * trafficSimulator constructor.
     *
     * @param int   $trafficLightsPosition
     * @param int   $trafficLightsTime
     * @param array $vehicles
     * @param bool  $firstIsGreenLight
     */
    public function __construct(
        int $trafficLightsPosition = 50,
        int $trafficLightsTime = 10,
        array $vehicles = [0, 12, 20, 24],
        bool $firstIsGreenLight = true
    )
    {
        $this->trafficLightsPosition = $trafficLightsPosition;
        $this->trafficLightsTime     = $trafficLightsTime;
        $this->vehicles              = $vehicles;
        $this->firstIsGreenLight     = $firstIsGreenLight;

        $this->__setDuration();
    }

    /**
     * Render traffic
     */
    public function render()
    {
        if (!$this->vehicles) {
            exit('There are no vehicles to drive!');
        }

        if ($this->trafficLightsTime < 1) {
            exit('The traffic lights is faulty!');
        }

        foreach ($this->vehicles as $vehicle) {
            $this->__renderRow($vehicle);
        }
    }

    /**
     * @param $vehicle int
     */
    private function __renderRow($vehicle)
    {
        $passed = 0;

        $trafficLightsPassed = false;

        $waitedForTrafficLights = 0;

        while ($passed < $this->duration + $vehicle) {
            switch (true) {
                case $vehicle > $passed:
                    echo "*";
                    break;
                case $vehicle === $passed:
                    echo "START";
                    break;
                case $vehicle < $passed:
                    if (!$trafficLightsPassed) {
                        if ($this->__isOnTrafficLights($passed)) {
                            if ($this->__isTrafficLightsGreen($passed - $vehicle + 1)) {
                                if ($vehicle <= $this->trafficLightsPosition) {
                                    echo "<span style='color: green;'>-MOVE-</span>";
                                } else {
                                    echo "*";
                                }
                                $trafficLightsPassed = true;
                            } else {
                                $waitedForTrafficLights++;
                                echo "<span style='color: red; font-weight: bold'>*</span>";
                            }
                        } else {
                            echo "*";
                        }
                    } else {
                        echo "*";
                    }

                    break;
            }
            $passed++;
        }
        echo "FINISH (waited $waitedForTrafficLights seconds) <br>";
    }

    /**
     * @param $position
     *
     * @return bool
     */
    private function __isOnTrafficLights($position): bool
    {
        return $position >= $this->trafficLightsPosition &&
            $position < ($this->trafficLightsPosition + $this->trafficLightsTime);
    }

    /**
     * @duration setter
     */
    private function __setDuration()
    {
        $furtherPosition = min($this->vehicles);

        while ($furtherPosition <= $this->trafficLightsPosition) {

            $this->duration++;

            if ($furtherPosition === $this->trafficLightsPosition) {
                if ($this->__isTrafficLightsGreen($this->duration)) {
                    $furtherPosition++;
                }
            } else {
                $furtherPosition++;
            }
        }
    }

    /**
     * @param $position
     *
     * @return bool
     */
    private function __isTrafficLightsGreen($position): bool
    {
        if ((floor($position / $this->trafficLightsTime) % 2) == 0) {
            if ($this->firstIsGreenLight) {
                return true;
            }
        } else {
            if (!$this->firstIsGreenLight) {
                return true;
            }
        }

        return false;
    }
}
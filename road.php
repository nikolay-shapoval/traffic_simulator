<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 01.04.2020
 * Time: 12:44
 */

class Road
{
    /**
     * @var Vehicle[]
     */
    private $vehicles = [];

    /**
     * @var TrafficLights[]
     */
    private $trafficLights = [];

    /**
     * @var int
     */
    private $lastTrafficLights = 0;

    /**
     * @var int
     */
    private $duration = 0;

    /**
     * @param Vehicle $vehicle
     */
    public function addVehicle(Vehicle $vehicle)
    {
        $this->vehicles[] = $vehicle;
    }

    /**
     * @param TrafficLights $trafficLights
     */
    public function addTrafficLights(TrafficLights $trafficLights)
    {
        $this->trafficLights[] = $trafficLights;

        foreach ($this->trafficLights as $trafficLights) {
            if ($trafficLights->getPosition() > $this->lastTrafficLights) {
                $this->lastTrafficLights = $trafficLights->getPosition();
            }
        }
    }

    /**
     * Render traffic
     */
    public function render()
    {
        $this->__setDuration();

        if (!$this->vehicles) {
            exit('There are no vehicles to drive!');
        }

        if ($this->lastTrafficLights < 1) {
            exit('The traffic lights is faulty!');
        }

        foreach ($this->vehicles as $vehicle) {
            $this->__renderRow($vehicle);
        }
    }

    /**
     * @param Vehicle $vehicle
     */
    private function __renderRow(Vehicle $vehicle)
    {
        $passed = 0;

        $trafficLightsPassed = false;

        $waitedForTrafficLights = 0;

        while ($passed < $this->duration + $vehicle->getPosition()) {
            switch (true) {
                case $vehicle->getPosition() > $passed:
                    echo "*";
                    break;
                case $vehicle->getPosition() === $passed:
                    echo "START";
                    break;
                case $vehicle->getPosition() < $passed:
                    if (!$trafficLightsPassed) {
                        if ($trafficLights = $this->__isOnTrafficLights($passed)) {
                            if ($this->allTrafficLightsGreen($passed - $vehicle->getPosition() + 1)) {
                                if ($vehicle->getPosition() <= $trafficLights->getPosition()) {
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
            $passed += $vehicle->getSpeed();
        }
        echo "FINISH (waited $waitedForTrafficLights seconds) <br>";
    }

    /**
     * @param $position
     *
     * @return bool | TrafficLights
     */
    private function __isOnTrafficLights($position)
    {
        foreach ($this->trafficLights as $trafficLights) {
            if ($trafficLights->isOnTrafficLights($position)) {
                return $trafficLights;
            }
        }

        return false;
    }

    /**
     * @param $position
     *
     * @return bool
     */
    private function allTrafficLightsGreen($position): bool
    {
        foreach ($this->trafficLights as $trafficLight) {
            if (!$trafficLight->isTrafficLightsGreen($position)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @duration setter
     */
    private function __setDuration()
    {
        $furtherPosition = 0;
        $furtherVehicle  = null;

        foreach ($this->vehicles as $vehicle) {
            if ($this->lastTrafficLights - $vehicle->getPosition() > $furtherPosition) {
                $furtherPosition = $this->lastTrafficLights - $vehicle->getPosition();
                $furtherVehicle  = $vehicle;
            }
        }

        if ($furtherVehicle) {
            $furtherPosition = $furtherVehicle->getPosition();
            while ($furtherPosition <= $this->lastTrafficLights) {
                $this->duration++;

                if ($furtherPosition === $this->lastTrafficLights) {
                    if ($this->allTrafficLightsGreen($this->duration)) {
                        $furtherPosition++;
                    }
                } else {
                    $furtherPosition++;
                }
            }
        }
    }
}
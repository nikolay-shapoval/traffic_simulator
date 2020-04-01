<?php
/**
 * Created by PhpStorm.
 * User: Nikolay
 * Date: 01.04.2020
 * Time: 8:41
 */

require_once ('road.php');
require_once ('trafficLights.php');
require_once ('vehicle.php');


$road = new Road();

$road->addVehicle(new Vehicle(0));
$road->addVehicle(new Vehicle(12));
$road->addVehicle(new Vehicle(20));
$road->addVehicle(new Vehicle(24));

$road->addTrafficLights(new TrafficLights(50, 10));

$road->render();
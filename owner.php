<?php
require('vehicle.php');

class owner {
	$carNumber;
	$vehType;
	$plugTime;
	$totalBatt;
	$ranGas = false;
	
	function __construct() {
		// This chooses the number of vehicles
		double d = Math.random();
		if($d<=.9) {$carNumber = 1;}
		else{$carNumber = 2;}
		$vehType = new vehicle();
		$this->vehType = $vehType;
		
		// This sets the plug in time between 5 and 9 PM.
		$plugTime = rand(0,1000000000)/500000000+20;
		getTotalBattery();
	}
	
	function getTotalBattery() {
		// The first part calculates the random number of miles that the
		// owner drove that day. According to the site below, about 40 miles
		// per day is average. This then adds up to +-5 miles.
		// https://www.fhwa.dot.gov/ohim/onh00/bar8.htm
		$d = rand(0,1000000000)/200000000;
		$e = rand(0,1000000000)/1000000000;
		$dailyMiles = 41.1;
		if($e>.5) {$dailyMiles += $d;}
		else{$dailyMiles -= $d;}
		
		// The next step is to compare it to the battery life. If the miles driven are farther than the
		// electric range, set ranGas to TRUE and set battery to 0. Else, calculate what percentage of
		// the battery is left, and set the totalBatt to that.
		if($vehType->getMaxMilesEV()<$dailyMiles) {
			$ranGas = true;
			$totalBatt = $vehType->getBattSize()*$carNumber;
		}
		else {
			$percentBatt = $dailyMiles/$vehType->getMaxMilesEV();
			$totalBatt = $vehType->getBattSize()*$percentBatt;
		}
		$this->totalBatt = $totalBatt;
		$this->ranGas = $ranGas;
	}
	
	function getChargeHour($hour) {
		$currCharge = 0;
		$chargePerHour = $carNumber*($vehType->getBattSize()/$vehType->getChargeTime());
		
		//set currCharge of vehicles
		if($hour<$plugTime) {
			$currCharge = (24-$plugTime+$hour)*$chargePerHour;
			
		}
		else if($hour>=$plugTime) {
			$currCharge = ($hour - $plugTime + 1)*$chargePerHour;
		}
		
		if($currCharge>$totalBatt) {return 0;}
		else {return $chargePerHour;}
	}
	
	function getVehType() {
		return $this->vehType->getName();
	}
	
	function getCarNum() {
		return $this->carNumber;
	}
}

?>

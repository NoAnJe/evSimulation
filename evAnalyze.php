<?php

require ('owner.php');
require ('vehicle.php');

class EVAnalysis {
 //Defines list of owners, hours, and total kWh being used per hour
 $evOwners;
 $hours;
 $hourTotals;
 $carNumbers;
 $carTypes;
 
	function __construct($numOwners)) {
        $evOwners = array();
        $hours = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);
        $hourTotals = array(0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0);
        $carNumbers = array(0,0,0,0,0,0,0,0,0,0);
        $carTypes = array("Chevrolet Volt", "Nissan Leaf", "Tesla Model S",
 			"Toyota Prius PHV", "Ford Fusion Energi", "Ford C-Max Energi",
 			"BMW i3", "Fiat 500e", "Tesla Model X", "Volkswagen e-Golf");
		$evOwners = $this->evOwners;
		$hours = $this->hours;
		$hourTotals = $this->hourTotals;
		$carNumbers = $this->carNumbers;
		$carTypes = $this->carTypes;		
		
		for($i=0;$i<$numOwners;$i++) {
			$evOwners[$i] = new owner();
		}
		
		//Calculates power per hour
		calculateChargeTime();
		
		for($j=0;$j<=23;$j++) {
			echo "Hour: " + $hours[$j] + " Amount of Power (kWh): " + $hourTotals[$j]);
		}
		
		// Calculates the total power
		$totPower = 0;
		for($j=0;$j<=23;$j++) {
			$totPower += $hourTotals[$j];
		}
		echo "Total power used: " + $totPower + " kWh";
		
		// Calculates number of each vehicle
		$size = sizeof($evOwners);
		
		for($k = 0;$k<=9;$k++) {
			for($l = 0; $l<$size; $l++) {// This loop goes through each owner
				$st = $evOwners[$l]->getVehType();
				if($st==$carTypes[$k]) {
					$carNumbers[$k] = $carNumbers[$k] + $evOwners[$l]->getCarNum();
				}
			}
			echo $carTypes[$k].": ".$carNumbers[$k]);
		}
	}
	
	function calculateChargeTime() {
		$hourTotals = $this->hourTotals;
		$evOwners = $this->evOwners;
		
		for($i=0;$i<=23;$i++) {
			$kWh = 0;
			
			for($j=0; $j<sizeof($evOwners); $j++) {
				$currTotal = $evOwners[$j]->getChargeHour($i);
				$kWh = $kWh + $currTotal;
			}
			
			$hourTotals[$i] = $kWh;
		}
	}
	
	// This loop returns true if it ever ran gas
	function noElec() {
		$evOwners = $this->evOwners;
		
		for($i=0;$i<sizeof($evOwners);$i++) {
			if($evOwners[$i]->ranGas) {
				return true;
			}
		}
		return false;
	}
}

?>
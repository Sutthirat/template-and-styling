<?php

$motorcycle_speed = 60; // km/h
$motorcycleFuelTank = 5; // liters
$motorcycle_fuel_consumptionRate = 10; # km/liter

$carSpeed = 100; // km/h
$carFuelTank = 40; // liters
$car_fuel_consumptionRate = 8; # km/liter

$busSpeed = 80; // km/h
$busFuelTank = 200; // liters
$bus_fuel_consumptionRate = 5; # km/liter

function getTimeSpent($type ,$distance){
	global $motorcycle_speed;
	global $carSpeed;
	global $busSpeed;

    if ($type=='motorcycle')
    {
		return $distance / $motorcycle_speed;
    }
    else if ($type=='car')
    {
		return $distance / $carSpeed;
    }
    else if ($type=='bus')
    {
		return $distance / $busSpeed;
    }
    else
    {
		return false;
    }
}

// Every vehicle starts with the full fuel tank.
function getFuelStopNeed($type,$distance) {
    global $motorcycleFuelTank;
	global $motorcycle_fuel_consumptionRate;
    global $carFuelTank;
    global $car_fuel_consumptionRate;
    global $busFuelTank;
	global $bus_fuel_consumptionRate;

    if ($type=='motorcycle')
	{
		$time = floor($distance /($motorcycle_fuel_consumptionRate*$motorcycleFuelTank));
		return ($time < 0) ? 0 : $time;
	} else if ($type=='car')
    {
		$time = floor($distance/( $car_fuel_consumptionRate* $carFuelTank));
		return ($time < 0) ? 0 : $time;
	} else if ($type=='bus')
	{
		$time = floor($distance / ($bus_fuel_consumptionRate *$busFuelTank));
		return ($time < 0) ? 0 : $time;
	} else
	{
		return false;
    }
}

$distance = 120;

echo 'Distance: ' . $distance.'km(s)';
echo "\n";

$vehicle = 'motorcycle';
echo 'Vehicle: ' . ucfirst($vehicle) . ', Time spent: ' . getTimeSpent($vehicle, $distance) . 'hr(s), Fuel stop: ' . getFuelStopNeed($vehicle, $distance);
echo "\n";

$vehicle = 'car';
echo 'Vehicle: ' . ucfirst($vehicle) . ', Time spent: ' . getTimeSpent($vehicle, $distance) . 'hr(s), Fuel stop: ' . getFuelStopNeed($vehicle, $distance);
echo "\n";

$vehicle = 'bus';
echo 'Vehicle: ' . ucfirst($vehicle) . ', Time spent: ' . getTimeSpent($vehicle, $distance) . 'hr(s), Fuel stop: ' . getFuelStopNeed($vehicle, $distance);
echo "\n";

?>

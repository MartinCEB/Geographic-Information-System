<?php

class Formulas{

	CONST EARTH_RADIUS = 6378137;
	function __construct(){
		
	}
	
	public static function distance($location, $target,$unit){
		$lon1 = $location["lng"];
		$lon2 = $target["lng"];
		$lat1 = $location["lat"];
		$lat2 = $target["lat"];
		
		$theta = $lon1 - $lon2;
		$dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
		$dist = acos($dist);
		$dist = rad2deg($dist);
		$miles = $dist * 60 * 1.1515;
		$unit = strtoupper($unit);

		if ($unit == "K") {
			return ($miles * 1.609344);
		} else if ($unit == "N") {
			return ($miles * 0.8684);
		} else {
			return $miles;
		}
	}
	
	
	function bearing($a,$b) {
		
		$lat1 = $a["lat"];
		$lat2 = $b["lat"];
		
		$lon1 = $a["lng"];
		$lon2 = $b["lng"];
		
		if (round($lon1, 1) == round($lon2, 1)) {
			if ($lat1 < $lat2) {echo "3";
				$bearing = 0;
			} else {
				$bearing = 180;
			}
		} else {
			$dist = $this->distance($a, $b, 'N');
			echo $dist;
			$arad = acos((sin(deg2rad($lat2)) - sin(deg2rad($lat1)) * cos(deg2rad($dist / 60))) / (sin(deg2rad($dist /
			60)) * cos(deg2rad($lat1))));
			$bearing = $arad * 180 / pi();
			if (sin(deg2rad($lon2 - $lon1)) < 0) {
				$bearing = 360 - $bearing;
			}
		}

		$dirs = array("N","E","S","W");

		$rounded = round($bearing / 22.5) % 16;
		if (($rounded % 4) == 0) {
			$dir = $dirs[$rounded / 4];
		} else {
			$dir = $dirs[2 * floor(((floor($rounded / 4) + 1) % 4) / 2)];
			$dir .= $dirs[1 + 2 * floor($rounded / 8)];
			#if ($rounded % 2 == 1)
			#  $dir = $dirs[round_to_int($rounded/4) % 4] . "-" . $dir;
		}

		//return $dir;
		return $bearing;
	}
	
	
}

?>
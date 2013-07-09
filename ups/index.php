<?php
	if(!isset($_GET['id'])) {
		exit("{'error':'Missing ID parameter'}");
	}
	
	$id = $_GET['id'];
	
	if(!preg_match('#^1Z[0-9A-Z]+$#i',$id)) {
		exit("{'error':'Incorrect ID'}");
	}
	
	$page = file_get_contents('http://wwwapps.ups.com/WebTracking/track?track=yes&trackNums=' . $id);
	$split = explode('<label>Scheduled Delivery:</label>',$page);
	$split = $split[1];
	preg_match_all('#<dd>(.+)</dd>#isU',$split,$date_d);
	$date_d = $date_d[1];
	unset($date_d[7]);
	
	//Departure
	$res['date_d'] = $date_d[3];
	
	//Arrival
	$date_at = explode(',&nbsp;',$date_d[0]);
	$res['date_a']['date'] = $date_at[1];
	$res['date_a']['hour'] = $date_at[2];
	
	//Weight
	$res['weight'] = $date_d[5];
	
	//Number of parcels
	$res['number'] = $date_d[2];
	
	//Destination
	preg_match_all('#<strong>[^A-Z]*([A-Z]+),[^A-Z]*([A-Z]+)[^A-Z]*</strong>#isU',$date_d[6],$city_to);
	$res['destination']['city'] = $city_to[1][0];
	$res['destination']['country'] = $city_to[2][0];
	
	$split = explode('<div class="secLvl gradient gradientGroup7 module3">',$page);
	$split = $split[1];
	preg_match_all('#<td( class="nowrap")?>(.+)</td>#isU',$split,$stapes);
	$stapes = $stapes[2];

	$nb = floor(count($stapes)/4);
	for($i=0;$i<$nb*4;$i++) {
		if($i%4==0) { //City
			$onlyLN = onlyLN($stapes[$i]);
			if(!empty($onlyLN)) { //There is a city
				$temp = explode(',',$onlyLN);
				if(empty($temp[1])) {
					$res['stapes'][floor($i/4)]['country'] = $temp[0];
				} else {
					$res['stapes'][floor($i/4)]['city'] = $temp[0];
					$res['stapes'][floor($i/4)]['country'] = $temp[1];
				}
			} else { //Same city
				$res['stapes'][floor($i/4)] = $res['stapes'][floor($i/4)-1];
			}
		} elseif($i%4==1) { //Date
			$res['stapes'][floor($i/4)]['date'] = onlyLN($stapes[$i]);
		} elseif($i%4==2) { //Hour
			$temp = explode(':',onlyLN($stapes[$i]));
			$temp[1] = str_replace('A.M.','',$temp[1]);
			$temp[1] = str_replace('P.M.','',$temp[1]);
			if(preg_match('#P\.M\.#i',$stapes[$i]) and $temp[0]!=12) {
				$res['stapes'][floor($i/4)]['hour'] = ($temp[0]+12) . ':' . $temp[1];
			} else {
				$res['stapes'][floor($i/4)]['hour'] = ($temp[0]) . ':' . $temp[1];
			}
		} elseif($i%4==3) { //Activity
			$res['stapes'][floor($i/4)]['activity'] = trim($stapes[$i]);
		}
	}
	
	echo json_encode($res);
	
	function onlyLN($text) {
		$ret = preg_replace('#[^a-z0-9,/:.]+#isU','',$text);
		return $ret;
	}

<?php

session_start();
	
$ip = $_SESSION['IP'];	
	
if ($_SESSION['location'] == "" || $_GET["Dump"] == "true")
{
	$ip = $_SERVER['REMOTE_ADDR'];
	// remember chmod 0777 for folder 'cache'
	
	if (!is_string($ip) || strlen($ip) < 1 || $ip == '127.0.0.1' || $ip == 'localhost')
		$ip = '71.220.137.86';
	
	$file = "cache/".$ip;
	
	if(!file_exists($file)) {
		// request
		$json = file_get_contents("http://api.easyjquery.com/ips/?ip=".$ip."&full=true");
		$f = fopen($file,"w+");
		fwrite($f,$json);
		fclose($f);
	} else {
		$json = file_get_contents($file);
	}
	
	//echo $json;
	
	$json = json_decode($json,true);

	if ($_GET["Dump"] == "true")
	{
		echo "<pre>";
		print_r($json);
	}
	
	
	$_SESSION['IP'] = $json["IP"];
	$_SESSION['location'] = ucwords(strtolower($json["cityName"])) . ", " . ucwords(strtolower($json["regionName"]));
	$_SESSION['location_url'] = "/" . strtolower(str_replace(" ", "_", $json["regionName"])) . "/" . strtolower(str_replace(" ", "_", $json["cityName"]));
	
	$_SESSION['regionName'] = $json["regionName"];
	$_SESSION['cityName'] = $json["cityName"];
	//echo "Set IP Address: " . $json["IP"];
}
else
{
	//echo "Session Already Set: " . $ip;
}
?>

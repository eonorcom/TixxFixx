<?php
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	
	//AIzaSyBmMr4zQEPIiBtg7GcxwNoDVJwQ6yBoUMY	
		
	$Search = $_GET['Search'];
	$url = "http://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=" . urlencode($Search) . "&userip=71.220.137.86&rsz=8";
	
	
	$ch = curl_init($url);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			
	$query_result = curl_exec($ch);
	
	curl_close($ch);
	
	echo $query_result;
	
?>

<?php 
	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');
	
	require_once "eventful/eventful.old.php";

	$AppKey = "TDz4XswWTpKVmzsS";

	$eV = new Eventful($AppKey);

	$evLogin = $eV->login('block2150', 'beaver');
	if($evLogin) {
		
		$evArgs = array(
		);
		
		$json = $eV->call('/categories/list', $evArgs);
		
		if ($_GET["Dump"] == "true")
		{
			$json = json_decode($json,true);
			
			echo "<pre>";
			print_r($json);
		}
		else
		{
			echo $json;
		}

	}else{
		die("<strong>Error logging into Eventful API</strong>");
	}


?>
<?php 
    require 'eventful/EVDB.php';
	
	session_start();

	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');


	$file_path = 'cache/';
	$cache_life = '3600';
	
	$c = $_GET["c"];
	$d = $_GET["d"];
	
	if ($c == "")
	{
		$c = "music";	
	}
	if ($d == "")
	{
		$d = "Future";	
	}
	
    // Enter your application key here. (See http://api.evdb.com/keys/)
    $app_key = 'TDz4XswWTpKVmzsS';
    
    // Authentication is required for some API methods.
    $user     = 'block2150';
    $password = 'beaver';

    $evdb = &new Services_EVDB($app_key);
    
    if ($user and $password)
    {
      $l = $evdb->login($user, $password);
      
      if ( PEAR::isError($l) )
      {
          print("Can't log in: " . $l->getMessage() . "\n");
      }
    }
	
	$filename = $file_path . strtolower(str_replace(", ", "-", $_SESSION['location'])) . "-" . $c . "-" . $d . ".txt";
	$filemtime = @filemtime($filename);
	
	if (!$filemtime or (time() - $filemtime >= $cache_life)){
		//Get from remote
		
		$args = array(
			'location' => $_SESSION['location'],
			'category' => $c,
			'date' => $d, // "All", "Future", "Past", "Today", "Last Week", "This Week", "Next week", and months by name, e.g. "October"
			'page_size' => '50',
			'page_number' => 0,
			'sort_order' => 'date',
			'within' => '100',
			'units' => 'mi',
			'include' => 'categories,price,links',
			'sort_direction' => 'ascending' //	 'ascending' or 'descending'	
		);
	
		$event = $evdb->call('events/search', $args);
		
		
		if ( PEAR::isError($event) )
		{
			print("An error occurred: " . $event->getMessage() . "\n");
			print_r( $evdb );
		}
		
		if (!$cache = fopen($filename, 'w+')) {
			echo "Cannot open file ($filename)";
			exit;
		}
		// Write $somecontent to our opened file.
		if (fwrite($cache, json_encode($event)) === FALSE) {
			echo "Cannot write to file ($filename)";
			exit;
		}
		
		fclose($cache);
		
		if ($_GET["Dump"] == "true")
		{	
			echo "Set Cache: " . $filename . "\n";
			print_r($event);
		}
		else
		{
			echo json_encode($event);
		}
	}
	else
	{	
		$cache = fopen($filename, "r");
		$event = fread($cache, filesize($filename));
		fclose($handle);
		
		if ($_GET["Dump"] == "true")
		{	
			echo "Get Cache: " . $filename . "\n";
			echo "Cache Time: " . (time() - $filemtime) . " Cache Life: " . $cache_life . "\n";
			print_r(json_decode($event));
		}
		else
		{
			echo $event;
		}
	}
    // The return value from a call is an XML_Unserializer data structure.
	

?>
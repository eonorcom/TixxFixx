<?php 
    require 'eventful/EVDB.php';
	
	session_start();
	

	header('Cache-Control: no-cache, must-revalidate');
	header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	header('Content-type: application/json');

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
		
	$args = array(
		'location' => $_SESSION['location'],
		'category' => $_GET["c"],
		'keywords' => "title:" . $_GET["s"],
		'date' => "Future", // "All", "Future", "Past", "Today", "Last Week", "This Week", "Next week", and months by name, e.g. "October"
		'page_size' => '50',
		'page_number' => 1,
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
    
    // The return value from a call is an XML_Unserializer data structure.
	if ($_GET["Dump"] == "true")
	{	
		print_r($event);
	}
	else
	{
		echo json_encode($event);
	}


?>
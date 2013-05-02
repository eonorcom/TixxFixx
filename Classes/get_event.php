<?php
    require 'eventful/EVDB.php';

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
    
    // All method calls other than login() go through call().
    $args = array(
      'id' => 'E0-001-000249321-2',
    );
    $event = $evdb->call('events/get', $args);
    
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
		echo $event;
	}
        
?>
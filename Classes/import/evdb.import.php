
<?php 
	$time_start = microtime(true); 
	$Debug = 0;
	header('Content-type: text/plain');
	
    require '../eventful/EVDB.php';
    require 'data.db.php';
	
	session_start();
	// evdb  or cache
	$source = "evdb";
	$Market = "boise";
	$MarketID = 1;
	$Loop = 10;
	
	if ($source == "evdb")
	{
		$c = $_GET["c"];
		$d = $_GET["d"];
		$page = $_GET["page"];
		
		if ($page == "")
		{
			$page = 0;	
			$_SESSION['count'] = 0;
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
		
		$args = array(
			'location' => $Market,
			'date' => 'Future', // "All", "Future", "Past", "Today", "Last Week", "This Week", "Next week", and months by name, e.g. "October"
			'page_size' => '100',
			'page_number' => $page,
			'sort_order' => 'date',
			'within' => '100',
			'units' => 'mi',
			'include' => 'categories,price,links',
			'sort_direction' => 'ascending' //	 'ascending' or 'descending'	
		);
	
		$events = $evdb->call('events/search', $args);
		
		if ( PEAR::isError($event) )
		{
			print("An error occurred: " . $event->getMessage() . "\n");
			print_r($evdb);
		}
	}
	else
	{
		$url = 'http://www.tixxfixx.com/Classes/cache/boise-idaho-music-Future.txt';
		$content = file_get_contents($url);
		$events = json_decode($content, true);	
	}
	
	
	foreach ($events['events']['event'] as $event) {
		//import events

        $data_price = $event['price'];
        $data_desc = $event['description'];

        if (strlen($data_price) > 512)
        {
            $data_desc = $data_desc . " " . $data_price;
            $data_price = "";
        }

		data_events($event['id'],$MarketID,$event['venue_id'],$event['title'],$data_desc,$event['free'],$data_price,$event['start_time'],$event['stop_time'],$event['created'],$event['modified'],$source,$event['url']);
		
		//import venues
		data_venues($event['venue_id'],$MarketID,$event['venue_name'],$event['venue_address'],$event['city_name'],$event['region_abbr'],$event['postal_code'],$event['country_abbr'],$event['latitude'],$event['longitude'],$source,$event['venue_url']);
		
		
		//import image data
		if ($event['image']['url'] != "")
		{
			data_images($event['id'],$event['image']['url'],$event['image']['width'],$event['image']['height']);
		}
		
		//import links
		foreach ($event['links']['link'] as $link) {
			if (strpos($link['url'], 'http') !== FALSE)
			{
				data_links($link['id'],$event['id'],$link['url'],$link['type'],$link['description']);
			}
		}
		
		//import categories
		foreach ($event['categories'] as $category) {
			if ($category['id'] != "")
			{
				data_categories($event['id'],$category['id'],$category['name']);
			}
		}
		
		//import performers
		if ($event['performers'] != "")
		{
			foreach ($event['performers']['performer'] as $performer) {
				data_performers($event['id'],$performer['id'],$performer['name'],$performer['short_bio'],$source,$performer['url']);
			}
		}
		$LastStartTime = $event['start_time'];
	}
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start);
	
	echo 'Total Execution Time: '.$execution_time.' sec.   Last Event Date: ' .$LastStartTime .'   Session Count: '. $_SESSION['count'] . '';
	
	if ($_SESSION['count'] < $Loop)
	{
		$_SESSION['count'] = $_SESSION['count'] + 1;
		header("Location: evdb.import.php?page=" . $_SESSION['count']);
	}
?>
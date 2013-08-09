<?php 
	header('Content-type: text/plain');

	$time_start = microtime(true); 
	$Debug = 0;

    require '../pollstar/EVDB.php';
    require 'data.db.php';
	
	session_start();
	// evdb  or cache
	$source = "pollstar";
	$MarketID = 1;
	$Loop = 10;
	
	$c = $_GET["c"];
	$d = $_GET["d"];
	$page = $_GET["page"];
	
	if ($page == "")
	{
		$page = 0;	
		$_SESSION['pollstar_count'] = 0;
	}
	
	// Enter your application key here. (See http://api.evdb.com/keys/)
	$app_key = '20806-7494912';
	
	$evdb = &new Services_EVDB($app_key);
	
	$args = array(
		'cityID' => '10100',
		'radius' => '50', // "All", "Future", "Past", "Today", "Last Week", "This Week", "Next week", and months by name, e.g. "October"
		'StartDate' => '8/7/2013',
		'DayCount' => '360',
		'Page' => '1',
		'pageSize' => '50',
		'apiKey' => $app_key
	);

	$events = $evdb->call('api/pollstar.asmx/CityEvents', $args);
	
	if ( PEAR::isError($event) )
	{
		print("An error occurred: " . $event->getMessage() . "\n");
		print_r($evdb);
	}
	
	foreach ($events['Events']['Event'] as $event) {

		//import events
		$id = 'PS-' . $event['CityID'] . '-' . $event['EventID'];
		$title = $event['EventName'];
		$data_desc = "";
		$free = "";
		$data_price = "";
		$start_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $event['PlayDate'])));
		$stop_time = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $event['PlayDate'])));
		$created = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $event['UpdatedTime'])));
		$modified = date('Y-m-d H:i:s', strtotime(str_replace('-', '/', $event['UpdatedTime'])));
		
		$url_name = strtolower(str_replace(' ', '-', str_replace(array( '\'', '"', ',' , ';', '<', '>', '!', '(', ')', '{', '}', '&', '#', '@', '%', '*', '.', ',', '/', '?', ';', ':', '/' ), '', trim($event['EventName']))));
		$url = $url_name .'/'.$id;
		
		//$url = $event['Url'];

        $data_price = $event['price'];
		
        if (strlen($data_price) > 512)
        {
            $data_desc = $data_desc . " " . $data_price;
            $data_price = "";
        }

		
		$venue_id = data_get_venue($event['VenueName']);
		
		if ($venue_id == "")
		{
			//import venues
			$venue_id = 'PS-' . $event['CityID'] . '-' . $event['VenueID'] . '-0';
			$venue_name = $event['VenueName'];
			$venue_address = "";
			$city_name = $event['CityName'];
			$region_abbr = $event['State'];
			$postal_code = "";
			$country_abbr = "USA";
			$latitude = "";
			$longitude = "";
			$venue_url = "";	
			if ($venue_id != "")
			{
				data_venues($venue_id,$MarketID,$venue_name,$venue_address,$city_name,$region_abbr,$postal_code,$country_abbr,$latitude,$longitude,$source,$venue_url);
			}
		}


		data_events($id,$MarketID,$venue_id,$title,$data_desc,$free,$data_price,$start_time,$stop_time,$created,$modified,$source,$url);

		
		//import performers
		if ($event['performer_id'] != "")
		{	
			foreach ($event['Artists']['Artist'] as $performer) 
			{			
				$performer_id = data_get_performer($performer['ArtistName']);
				
				if ($performer_id == "") 
				{
					$performer_id = 'PS-' . $performer['ActCode'] . '-' . $performer['ArtistTypeID'] . '-' . $performer['ArtistID'] . '-0';
					$performer_name = $performer['ArtistName'];
					$performer_short_bio = "";
					$performer_url = $performer['Url'];		
					data_performers($id,$performer_id,$performer_name,$performer_short_bio,$source,$performer_url);
				}
				else
				{
					data_event_performers($id,$performer_id);
				}
			}
		}
		
		
		//import image data
		$imageUrl = "";
		$imageWidth = "";
		$imageHeight = "";
		if ($eventImage != "")
		{
			data_images($id,$eventImage,$imageWidth,$imageHeight);
		}
		
		//import links
		$importLinks = 1;
		if ($importLinks == 1)
		{
			$link_id = $id;
			$link_url = $event['Url'];
			$link_type = 'Info';
			$link_description = 'Event Details at Pollstar.com';
			
			data_links($link_id,$id,$link_url,$link_type,$link_description);
		}
		
		//import categories
		$importCategories = 1;
		if ($importCategories == 1)
		{
			data_event_categories($id,'music');
		}
		
		$LastStartTime = $start_time;
	}
	$time_end = microtime(true);
	$execution_time = ($time_end - $time_start);
	
	echo 'Total Execution Time: '.$execution_time.' sec.   Last Event Date: ' .$LastStartTime .'   Session Count: '. $_SESSION['pollstar_count'] . '';
	
	if ($_SESSION['pollstar_count'] < $Loop)
	{
		$_SESSION['pollstar_count'] = $_SESSION['pollstar_count'] + 1;
		header("Location: pollstar.import.php?page=" . $_SESSION['pollstar_count']);
	}
?>
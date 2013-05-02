<?php
	session_start();
	
	$Debug = 1;
    require 'import/data.db.php';
	$MarketID = 1;
	
	$hash = md5(uniqid(rand(), TRUE));
	$NewEventID = 'E-'. strtoupper(substr($hash, 0, 6)) . "-" . strtoupper(substr($hash, 8, 3)) . "-" . strtoupper(substr($hash, 12, 8));
	
	$hash = md5(uniqid(rand(), TRUE));
	$NewVenueID = 'V-'. strtoupper(substr($hash, 0, 6)) . "-" . strtoupper(substr($hash, 8, 3)) . "-" . strtoupper(substr($hash, 12, 8));
	
	$hash = md5(uniqid(rand(), TRUE));
	$NewPerformerID = 'P-'. strtoupper(substr($hash, 0, 6)) . "-" . strtoupper(substr($hash, 8, 3)) . "-" . strtoupper(substr($hash, 12, 8));
	
	
	$AddVenue = 0;
	$AddPerformer = 0;
	$AddNamespace = 0;
	
	$EventID = $_POST['event-details-EventID'];
	$VenueID = $_POST['event-details-VenueID'];
	$PerformerID = $_POST['event-details-PerformerID'];
	$Namespace = $_POST['event-details-Namespace'];
	
	$Title = $_POST['Title'];
	$Description = $_POST['Description'];
	$Price = $_POST['Price'];
	$Free = $_POST['Free'];
	
	
	if ($_POST['StartTime'] == "")
	{
		$StartTime = NULL;
	}
	if ($_POST['StopTime'] == "")
	{
		$StopTime = NULL;
	}
	
	
	
	if ($EventID == "")
	{
		$EventID = $NewEventID;
	}
	
	if ($VenueID == "")
	{
		$VenueID = $NewVenueID;
		$AddVenue = 1;
	}
	$EventUrl = "/boise/events/" . str_replace(" ", "-", strtolower($Title)) . "/" .$EventID;
	
	data_events($EventID,$MarketID,$VenueID,$Title,$Description,$Free,$Price,$StartTime,$StopTime,'','','tixx',$EventUrl);
	
	if ($AddVenue == 1)
	{
		
		$Name = $_POST['Name'];		
		$Adress = $_POST['Address'];
		$City = $_POST['City'];
		$Region = $_POST['Region'];
		$Zip = $_POST['Zip'];
		
		$VenueUrl = "/boise/events/" . str_replace(" ", "-", strtolower($Name)) . "/" .$VenueID;
		
		data_venues($VenueID,$MarketID,$Name,$Adress,$City,$Region,$Zip,'USA','','','tixx', $VenueUrl);
	}
//	
//	
//	//import image data
//	if ($event['image']['url'] != "")
//	{
//		data_images($event['id'],$event['image']['url'],$event['image']['width'],$event['image']['height']);
//	}
//	
//	//import links
//	foreach ($event['links']['link'] as $link) {
//		if (strpos($link['url'], 'http') !== FALSE)
//		{
//			data_links($link['id'],$event['id'],$link['url'],$link['type'],$link['description']);
//		}
//	}

	if ($Namespace == "")
	{
		$AddNamespace = 1;
	}
	
	if ($AddNamespace == 1)
	{
		$Namespace = str_replace(" ", "-", strtolower($_POST['Category']));
		$Category = $_POST['Category'];
		
		data_categories($EventID,$Namespace,$Category);
	}
	else
	{
		data_event_categories($EventID,$Namespace);
	}
	
	
	if ($PerformerID == "")
	{
		$AddPerformer = 1;
	}
	
	if ($AddPerformer == 1)
	{
		$PerformerID = $NewPerformerID;
		$PerformerName = $_POST['PerformerName'];
		$Bio = $_POST['Bio'];
		
		$PerformerUrl = "/boise/performer/" . str_replace(" ", "-", strtolower($PerformerName)) . "/" .$PerformerID;
		
		if ($PerformerName != "")
		{
			data_performers($EventID,$PerformerID,$PerformerName,$Bio,'tixx',$PerformerUrl);
		}
	}
	else
	{
		data_event_performers($EventID,$PerformerID);
	}
	
	header("Location: " . $EventUrl);
	


?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
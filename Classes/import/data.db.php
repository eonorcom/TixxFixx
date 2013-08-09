<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php

function data_events(
	$EventID,
	$MarketID,
	$VenueID,
	$Title,
	$Description,
	$Free,
	$Price,
	$StartTime,
	$StopTime,
	$Created,
	$Modified,
	$Source,
	$SourceURL
) 
{

	$import = sprintf("INSERT INTO data_events (
			EventID,MarketID,VenueID,Title,Description,Free,Price,StartTime,StopTime,Created,Modified,Source,SourceURL,Imported
		)
		VALUES
		(
			'%s','%s','%s','%s','%s','%s','%s',%s,%s,%s,%s,'%s','%s',NOW()
		)
		ON DUPLICATE KEY UPDATE
			VenueID = '%s',
			Title = '%s',
			Description = '%s',
			Free = '%s',
			Price = '%s',
			StartTime = %s,
			StopTime = %s,
			Created = %s,
			Modified = %s,
			Source = '%s',
			SourceURL = '%s',
			Imported = NOW()",
		mysql_real_escape_string($EventID),
		mysql_real_escape_string($MarketID),
		mysql_real_escape_string($VenueID),
		mysql_real_escape_string($Title),
		mysql_real_escape_string($Description),
		mysql_real_escape_string($Free),
		mysql_real_escape_string($Price),
        $StartTime == '' ? "NULL" : "'" . $StartTime . "'",
        $StopTime == '' ? "NULL" : "'" . $StopTime . "'",
        $Created == '' ? "NULL" : "'" . $Created . "'",
        $Modified == '' ? "NULL" : "'" . $Modified . "'",
		mysql_real_escape_string($Source),
		mysql_real_escape_string($SourceURL),
		mysql_real_escape_string($VenueID),
		mysql_real_escape_string($Title),
		mysql_real_escape_string($Description),
		mysql_real_escape_string($Free),
		mysql_real_escape_string($Price),
        $StartTime == '' ? "NULL" : "'" . $StartTime . "'",
        $StopTime == '' ? "NULL" : "'" . $StopTime . "'",
        $Created == '' ? "NULL" : "'" . $Created . "'",
        $Modified == '' ? "NULL" : "'" . $Modified . "'",
		mysql_real_escape_string($Source),
		mysql_real_escape_string($SourceURL));


	$result = mysql_query($import);	
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
}


function data_venues(
	$VenueID,
	$MarketID,
	$Name,
	$Address,
	$City,
	$Region,
	$PostalCode,
	$Country,
	$Latitude,
	$Longitude,
	$Source,
	$SourceURL
) 
{
	//echo $SourceURL;
	
	$import = sprintf("INSERT IGNORE INTO data_venues (
			VenueID,MarketID,Name,Address,City,Region,PostalCode,Country,Latitude,Longitude,Source,SourceURL,Imported
		)
		VALUES
		(
			'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',NOW()
		)
		ON DUPLICATE KEY UPDATE
			Name = '%s',
			Address = '%s',
			City = '%s',
			Region = '%s',
			PostalCode = '%s',
			Country = '%s',
			Latitude = '%s',
			Longitude = '%s',
			Source = '%s',
			SourceURL = '%s',
			Imported = NOW()
		",
	mysql_real_escape_string($VenueID),
	mysql_real_escape_string($MarketID),
	mysql_real_escape_string($Name),
	mysql_real_escape_string($Address),
	mysql_real_escape_string($City),
	mysql_real_escape_string($Region),
	mysql_real_escape_string($PostalCode),
	mysql_real_escape_string($Country),
	mysql_real_escape_string($Latitude),
	mysql_real_escape_string($Longitude),
	mysql_real_escape_string($Source),
	mysql_real_escape_string($SourceURL),
	mysql_real_escape_string($Name),
	mysql_real_escape_string($Address),
	mysql_real_escape_string($City),
	mysql_real_escape_string($Region),
	mysql_real_escape_string($PostalCode),
	mysql_real_escape_string($Country),
	mysql_real_escape_string($Latitude),
	mysql_real_escape_string($Longitude),
	mysql_real_escape_string($Source),
	mysql_real_escape_string($SourceURL));
	//echo $import . "\n\n";
	$result = mysql_query($import);	
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
}

function data_images(
	$EventID,
	$Url,
	$Width,
	$Height
) 
{ 
	$import = sprintf("INSERT INTO data_images (
			EventID,Url,Width,Height,Imported
		)
		VALUES
		(
			'%s','%s','%s','%s',NOW()
		)
		ON DUPLICATE KEY UPDATE
			Url = '%s',
			Width = '%s',
			Height = '%s',
			Imported = NOW()
		",
	mysql_real_escape_string($EventID),
	mysql_real_escape_string($Url),
	mysql_real_escape_string($Width),
	mysql_real_escape_string($Height),
	mysql_real_escape_string($Url),
	mysql_real_escape_string($Width),
	mysql_real_escape_string($Height));
	//echo $import . "\n\n";
	$result = mysql_query($import);	
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
}

function data_links(
	$LinkID,
	$EventID,
	$Url,
	$Type,
	$Description
) 
{
	$import = sprintf("INSERT INTO data_links (
			LinkID,EventID,Url,Type,Description,Imported
		)
		VALUES
		(
			'%s','%s','%s','%s','%s',NOW()
		)
		ON DUPLICATE KEY UPDATE
			EventID = '%s',
			Url = '%s',
			Type = '%s',
			Description = '%s',
			Imported = NOW()
		",
	mysql_real_escape_string($LinkID),
	mysql_real_escape_string($EventID),
	mysql_real_escape_string($Url),
	mysql_real_escape_string($Type),
	mysql_real_escape_string($Description),
	mysql_real_escape_string($EventID),
	mysql_real_escape_string($Url),
	mysql_real_escape_string($Type),
	mysql_real_escape_string($Description));
	//echo $import . "\n\n";
	$result = mysql_query($import);	
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
}


function data_categories(
	$EventID,
	$Namespace,
	$Description
) 
{
	$import = sprintf("INSERT IGNORE INTO data_categories (
			Namespace,Description
		)
		VALUES
		(
			'%s','%s'
		)",
	mysql_real_escape_string($Namespace),
	mysql_real_escape_string($Description));
	//echo $import . "\n\n";
	$result = mysql_query($import);	
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
	
	
	
	
	
	$import = sprintf("INSERT IGNORE INTO data_event_categories (
			EventID,Namespace
		)
		VALUES
		(
			'%s','%s'
		)",
	mysql_real_escape_string($EventID),
	mysql_real_escape_string($Namespace));
	//echo $import . "\n\n";
	$result = mysql_query($import);	
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
}

function data_event_categories(
	$EventID,
	$Namespace
)
{
	
	
	$import = sprintf("INSERT IGNORE INTO data_event_categories (
			EventID,Namespace
		)
		VALUES
		(
			'%s','%s'
		)",
	mysql_real_escape_string($EventID),
	mysql_real_escape_string($Namespace));
	//echo $import . "\n\n";
	$result = mysql_query($import);	
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
}


function data_performers(
	$EventID,
	$PerformerID,
	$Name,
	$Bio,
	$Source,
	$SourceURL
) 
{	
	$import = sprintf("INSERT INTO data_performers (
			PerformerID,Name,Bio,Source,SourceURL,Imported
		)
		VALUES
		(
			'%s','%s','%s','%s','%s',NOW()
		)
		ON DUPLICATE KEY UPDATE
			Name = '%s',
			Bio = '%s',
			Source = '%s',
			SourceURL = '%s',
			Imported = NOW()
		",
	mysql_real_escape_string($PerformerID),
	mysql_real_escape_string($Name),
	mysql_real_escape_string($Bio),
	mysql_real_escape_string($Source),
	mysql_real_escape_string($SourceURL),
	mysql_real_escape_string($Name),
	mysql_real_escape_string($Bio),
	mysql_real_escape_string($Source),
	mysql_real_escape_string($SourceURL));
	//echo $import . "\n\n";
	$result = mysql_query($import);	
	$import = sprintf("INSERT IGNORE INTO data_event_performers (
			EventID,PerformerID
		)
		VALUES
		(
			'%s','%s'
		)",
	mysql_real_escape_string($EventID),
	mysql_real_escape_string($PerformerID));
	//echo $import . "\n\n";
	$result = mysql_query($import);
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
}

function data_event_performers(
	$EventID,
	$PerformerID
)
{
	
	$result = mysql_query($import);	
	$import = sprintf("INSERT IGNORE INTO data_event_performers (
			EventID,PerformerID
		)
		VALUES
		(
			'%s','%s'
		)",
	mysql_real_escape_string($EventID),
	mysql_real_escape_string($PerformerID));
	//echo $import . "\n\n";
	$result = mysql_query($import);
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
}
	
 
 
function data_get_venue(
	$Name
) 
{		
	$VenueID = "";
	
	$sql = sprintf("select * from data_venues where Name = '%s'",
	mysql_real_escape_string($Name));
	
	$result = mysql_query($sql);	
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
	
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$VenueID = $row["VenueID"];
	}
	
	return $VenueID;
}
 
 
function data_get_performer(
	$Name
) 
{		
	$PerformerID = "";
	
	$sql = sprintf("select * from data_performers where Name = '%s'",
	mysql_real_escape_string($Name));
	
	$result = mysql_query($sql);	
	$error = mysql_error() != '' ? true : false;
	
	if($error)
	{
		echo '<b>Post:</b><br>';
		print_r($_POST);
		echo '<br><br><b>Error:</b><br>' . mysql_error() . '<br><br>';
		echo '<b>Query:</b><br>' . $import . '<br><br>';
		exit;
	}
	
	while($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
		$PerformerID = $row["PerformerID"];
	}
	
	return $PerformerID;
}
 
?>
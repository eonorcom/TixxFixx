<?php

session_start();

$location = $_POST['location'];

$_SESSION['location'] = $location;

$pos = strrpos($location, ",");
if ($pos === false) 
{ 
	$location = strtolower(str_replace(" ", "_", $location));
}
else
{
	$location = explode(', ', $location);
	$state = $location[1];
	$city = $location[0];
	
	echo $state . "<br>";
	echo $city . "<br>";
	
	$location = strtolower(str_replace(" ", "_", $state)) . "/" . strtolower(str_replace(" ", "_", $city));
		
}


$url = htmlspecialchars($_SERVER['HTTP_REFERER']);

$path = explode('/', url);
if (count($path) == 4)
{
	$category = $path[3];
}
else
{
	$category = $path[4];	
}
if ($category == "")
{
	$category = "music";	
}

$location_url = "/" . $location;

$_SESSION['location_url'] = strtolower($location_url);

$redirect_path =  "/" . $location . "/events/" . $category;

echo "redirect_path: " . $redirect_path . "<br>";
echo "location_url: " . $location_url . "<br>";

echo "location: " . $_SESSION["location"];

header( "Location: " . $redirect_path . "" ) ;
?>

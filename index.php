<?php
include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  

//Always place this code at the top of the Page
session_start();
$Debug = "";

if($ShowLandingPage != "")
{
    $_SESSION['ShowTickets'] = 1;

    if ($_SESSION['ViewLanding'] != 1)
    {
        header("Location: " . $ShowLandingPage );
    }
}

//Array
//(
//    [0] => 
//    [1] => idaho
//    [2] => twin_falls
//    [3] => events
//    [4] => sports
//)
$EventID = "";
$category = "";
$search = "";
$ShowHomePage = 0;

$path = explode('/', $_SERVER['REQUEST_URI']);
$dateOptions = array("today","tomorrow","this-week","next-week","this-month");

if (count($path) == 2)
{
	$cklocation_url = "/" . $path[1];
	$cklocation = str_replace("_", " ", ucwords(strtolower($path[1])));
	$category = "";
	$ShowHomePage = 1;
}
if (count($path) == 3)
{
	$cklocation_url = "/" . $path[1];
	$cklocation = str_replace("_", " ", ucwords(strtolower($path[1])));
	$category = $path[3];
}
if (count($path) == 4)
{
	if ($path[3] == "events")
	{
		$cklocation_url = "/" . $path[1] . "/" . $path[2];
		$cklocation = str_replace("_", " ", ucwords(strtolower($path[2]))) . ", " . str_replace("_", " ", ucwords(strtolower($path[1])));
		$category = $path[4];
	}
	else
	{
		$cklocation_url = "/" . $path[1];
		$cklocation = str_replace("_", " ", ucwords(strtolower($path[1])));
		$category = $path[3];
	}
}
if (count($path) == 5)
{
	if (array_search($path[4], $dateOptions) !== false)
	{
//			echo "<div class='white'>Use Date</div>";
			$cklocation_url = "/" . $path[1];
			$cklocation = str_replace("_", " ", ucwords(strtolower($path[1])));
			$category = $path[3];	
			$date = $path[4];	
	}
	else
	{
		if (strrpos($path[4], "-") !== false)
		{
			$cklocation_url = $_SESSION['location_url'];
			$cklocation = $_SESSION['location'];
			$date = $_SESSION['date'];
			$category = $_SESSION['category'];
			$EventID = $path[4];
		}
		else
		{
//			echo "<div class='white'>No Date: " . array_search($path[4], $dateOptions) . "</div>";
			$cklocation_url = "/" . $path[1] . "/" . $path[2];
			$cklocation = str_replace("_", " ", ucwords(strtolower($path[2]))) . ", " . str_replace("_", " ", ucwords(strtolower($path[1])));
			$category = $path[4];	
			$date = "future";	
		}
	}
}
if (count($path) == 6)
{
	$cklocation_url = "/" . $path[1] . "/" . $path[2];
	$cklocation = str_replace("_", " ", ucwords(strtolower($path[2]))) . ", " . str_replace("_", " ", ucwords(strtolower($path[1])));
	$category = $path[4];	
	$date = $path[5];	
}

if (strpos($category, '?') !== FALSE)
{
	$temp = explode("?", $category, 2);
	$category = $temp[0];
	$temp = explode("=", $temp[1], 2);
	$search = urldecode($temp[1]);	
}

if (strpos($date, '?') !== FALSE)
{
	$temp = explode("?", $date, 2);
	$date = $temp[0];
	$temp = explode("=", $temp[1], 2);
	$search = urldecode($temp[1]);	
}
              
$sql = "select Namespace, Description from data_categories where Namespace = '". $category . "'";
$results = mysql_query($sql, $connection);
while($row = mysql_fetch_array($results, MYSQL_ASSOC)) {

	$Namespace = $row["Namespace"];
	$CategoryDescription = $row["Description"];
}

// Set Defaults
if ($category == "")
{
	$category = "music','sports','performing_arts";	
	$CategoryDescription = 'TixxFixx.com';
}

if ($cklocation_url == "/")
{
	$cklocation_url = "/boise";
	$cklocation = "Boise";
}


$BetweenStartDate = "";
$BetweenEndDate = "";
$BoldFuture = "";
$BoldToday = "";
$BoldTomorrow = "";
$BoldThisWeek = "";
$BoldNextWeek = "";
$BoldThisMonth = "";

switch ($date) 
{
	case "":
		$date = "Future";	
		$BetweenStartDate = "";
		$BetweenEndDate = "";	
		$BoldFuture = "font-weight: bold; color: #BD1E2D;";
		break;
	case "today":
		$date = "Today";	
		$BetweenStartDate = date('Y-m-d 00:00:00', strtotime('today'));
		$BetweenEndDate = date('Y-m-d  23:59:59', strtotime('today'));
		$BoldToday = "font-weight: bold; color: #BD1E2D;";
		break;	
		break;
	case "tomorrow":
		$date = "Tomorrow";	
		$BetweenStartDate = date('Y-m-d 00:00:00', strtotime('tomorrow'));
		$BetweenEndDate = date('Y-m-d  23:59:59', strtotime('tomorrow'));
		$BoldTomorrow = "font-weight: bold; color: #BD1E2D;";
		break;
	case "this-week":
		$date = "This Week";
		$BetweenStartDate = date('Y-m-d H:i:s', strtotime('Last Monday'));	
		$BetweenEndDate = date('Y-m-d 23:59:59', strtotime('Next Sunday'));
		$BoldThisWeek = "font-weight: bold; color: #BD1E2D;";
		break;
	case "next-week":
		$date = "Next Week";
		$BetweenStartDate = date('Y-m-d 00:00:00', strtotime('next week'));	
		$BetweenEndDate = date('Y-m-d  23:59:59', strtotime(date("Y-m-d H:i:s", strtotime('Next Sunday')) . " +1 week"));	
		$BoldNextWeek = "font-weight: bold; color: #BD1E2D;";
		break;
	case "this-month":
		$date = date("F");
		$BetweenStartDate = date('Y-m-d H:i:s',(strtotime('this month',strtotime(date('m/01/y')))));	
		$BetweenEndDate = date('Y-m-d H:i:s',(strtotime('next month',strtotime(date('m/01/y'))) - 1));
		$BoldThisMonth = "font-weight: bold; color: #BD1E2D;";
		break;
}
if ($cklocation_url != strtolower($_SESSION['location_url']))
{
	$_SESSION['location_url'] = $cklocation_url;
	$_SESSION['location'] = $cklocation;
}

$_SESSION['date'] = $date;
$_SESSION['category'] = $category;


          

if ($Debug == "true")
{
	echo "<div id='debug'>";
	echo "<div>ShowHomePage: ".$ShowHomePage."</div>";
	echo "<div>REQUEST_URI: ".$_SERVER['REQUEST_URI']."</div>";
	echo "<div>Path Count: ".count($path)."</div>";
	echo "<div>cklocation_url: ".$cklocation_url."</div>";
	echo "<div>cklocation: ".$cklocation."</div>";
	echo "<div>category: ".$category."</div>";
	echo "<div>Description: ".$Description."</div>";
	echo "<div>date: ".$date."</div>";
	echo "<div>EventID: ".$EventID."</div>";
	echo "<div>search: ".$search."</div>";
	echo "<div>BetweenStartDate: ".$BetweenStartDate."</div>";
	echo "<div>BetweenEndDate: ".$BetweenEndDate."</div>";
	echo "</div>";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" >
<head>

    <title>TixxFixx.com</title>
    <meta name="keywords" content="<?php echo $_SESSION['location'] ?>,  events,  concerts,  tickets,  concert tickets, buy  tickets, sell  tickets, trade  tickets">
    <meta name="description" content="TixxFixx  - Your Ticket Solution- Your place to buy, sell, trade, consign or upgrade your event or concert tickets.">

   	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/head.php");  ?>    
    <script>
		(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=435317736521241";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
</head>
<body>
    <div id="fb-root"></div>
	
	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/body.php");  ?>
    
</body>
</html>


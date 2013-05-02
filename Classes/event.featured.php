<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();
$Category = $_GET['c'];

// Status:
// 1 = Active, 3 = Suspended, 5 = In Review


	$sql = "select 
				e.EventID,
				e.VenueID,
				e.Category,
				e.EventTitle,
				e.EventDesc,
				e.EventURL,
				e.StartTime,
				e.EventImage,
				e.EventVenueMap,
				v.VenueName,
				v.VenueType,
				v.Address,
				v.City,
				v.State,
				v.PostalCode,
				v.Longitude,
				v.Latitude,
				p.PerformerName,
				p.Bio,
				(select sum(Qty) from tickets where EventID = e.EventID) as TotalTickets,
				(select min(Price) from tickets where EventID = e.EventID) as MinPrice,
				(select max(Price) from tickets where EventID = e.EventID) as MaxPrice
			from 
				events e
				inner join venues v on e.VenueID = v.VenueID
				left join tickets t on e.EventID = t.EventID
				left join performers p on e.PerformerID = p.PerformerID
			where
				e.Category = '$Category'
				and e.StartTime > Now()
			group by
				EventID
			order by
				e.StartTime";

$rs = mysql_query($sql, $connection);
while($obj = mysql_fetch_object($rs)) {
	$arr[] = $obj;
}
echo '{"featured":'.json_encode($arr).'}';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
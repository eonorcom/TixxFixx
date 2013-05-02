<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
header('Content-type: application/json');
session_start();



if ($UserID == "")
{
	$UserID = $_SESSION['id'];
}

	$sql = sprintf("SELECT 
						c.id as CartID,
						e.EventID,
						v.VenueID,
						t.id as TicketID,
						c.Qty,
						t.Price,
						c.Qty * t.Price as SubTotal,
						t.TicketType,
						t.TicketDesc,
						t.Section,
						t.Row,
						t.Seats,
						t.AdditionalInfo,
						t.eTixx,
						t.FedEx,
						t.WillCall,
						t.AddedBy,
						u.username,
						u.fullname,
						t.Contact,
						e.Title as EventTitle,
						e.Description as EventDesc,
						e.SourceURL,
						e.StartTime,
						v.Name as VenueName,
						v.Address,
						v.City,
						v.Region as State,
						TIMESTAMPDIFF(MINUTE, c.AddedOn, now()) as Expire
					from 
						cart_items c
						inner join tickets t on c.TicketID = t.id
						inner join data_events e on t.EventID = e.EventID
						inner join data_venues v on e.VenueID = v.VenueID
       					inner join users u on t.AddedBy = u.id
					where 
						TIMESTAMPDIFF(MINUTE, c.AddedOn, now()) < 20
						and c.Status = 0
						and c.UserID = '%s'", 
				mysql_real_escape_string($UserID));
	$rs = mysql_query($sql, $connection);
	
	while($obj = mysql_fetch_object($rs)) {
		$arr[] = $obj;
	}
	 
	echo '{"cart":'.json_encode($arr).'}';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
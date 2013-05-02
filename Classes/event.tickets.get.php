<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();



$EventID = $_GET["ID"];
if ($UserID == "")
{
	$UserID = $_SESSION['id'];
}

	$sql = sprintf("select 
				t.id,
				t.EventID,
				t.UserID,
				t.TicketType,
				t.TicketDesc,
				t.Section,
				t.Row,
				t.Seats,
				(Qty - Sold - IFNULL((select Qty from cart_items where TicketID = t.id and TIMESTAMPDIFF(MINUTE, AddedOn, now()) < 20),0)) as Qty,
				t.Price,
				t.Splits,
				t.AdditionalInfo,
				t.eTixx,
				t.FedEx,
				t.WillCall,
				t.Contact,
				t.AddedOn,        
				t.AddedBy,
			    u.username,
				u.fullname,
				t.UpdatedOn,
				t.UpdatedBy,
				t.Status
			from 
				tickets t
        		inner join users u on t.AddedBy = u.id
      		where 
        		t.EventID = '%s'", 
				mysql_real_escape_string($EventID));
	$rs = mysql_query($sql, $connection);
	
	while($obj = mysql_fetch_object($rs)) {
		$arr[] = $obj;
	}
	 
	echo '{"tickets":'.json_encode($arr).'}';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
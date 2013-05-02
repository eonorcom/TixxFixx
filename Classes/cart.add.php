<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$UserID = $_POST['UserID'];
$TicketID = $_POST['TicketID'];
$Qty = $_POST['Qty'];

$cleanup = sprintf("delete from cart_items where UserID = '%s' and TicketID = '%s'",
		mysql_real_escape_string($UserID),
		mysql_real_escape_string($TicketID));
$result = mysql_query($cleanup);

echo "$ID\n\n";

if ($ID == "")
{
	$insert = sprintf("insert into cart_items (UserID, TicketID, Qty, Status, AddedOn) values ('%s', '%s', '%s', 0, NOW())",
		mysql_real_escape_string($UserID),
		mysql_real_escape_string($TicketID),
		mysql_real_escape_string($Qty));
	echo "$insert\n\n";
	mysql_query($insert);
}

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
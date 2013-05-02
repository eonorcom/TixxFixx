<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$TicketID = $_POST['TicketID'];

$insert = sprintf("update tickets set Status = 5 where id = '%s'",
	mysql_real_escape_string($TicketID));
echo "$insert\n\n";
mysql_query($insert);

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
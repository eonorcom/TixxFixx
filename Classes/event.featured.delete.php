<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$EventID = $_POST['EventID'];

$insert = sprintf("update data_events set Featured = 0 where EventID = '%s'",
	mysql_real_escape_string($EventID));
echo "$insert\n\n";
mysql_query($insert);

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
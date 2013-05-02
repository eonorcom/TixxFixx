<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$EventID = $_POST['EventID'];
$Featured = $_POST['Featured'];

$insert = sprintf("update data_events set Featured = '%s' where EventID = '%s'",
	mysql_real_escape_string($Featured),
	mysql_real_escape_string($EventID));
echo "$insert\n\n";
mysql_query($insert);
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
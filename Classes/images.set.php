<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$ID = $_POST['ID'];
$Type = $_POST['Type'];
$Src = $_POST['Src'];

$UserID = $_SESSION['id'];

if ($Type == "Event")
{
	$update = sprintf("update events set EventImage = '%s', UpdatedOn = NOW(), UpdatedBy = '%s' where EventID = '%s'",
		mysql_real_escape_string($Src),
		mysql_real_escape_string($UserID),
		mysql_real_escape_string($ID));
}

echo $update;	
mysql_query($update);

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
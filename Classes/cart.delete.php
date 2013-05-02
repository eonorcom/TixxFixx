<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
header('Content-type: application/json');
session_start();

$CartID = $_POST['i'];


if ($UserID == "")
{
	$UserID = $_SESSION['id'];
}

	$sql = sprintf("delete from cart_items where ID = '%s'", 
				mysql_real_escape_string($CartID));
	$rs = mysql_query($sql, $connection);
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
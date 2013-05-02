<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$ID = $_POST['ID'];
$UserID = $_SESSION['id'];

$checkList = "select * from users_lists where UserID = $UserID and LibraryID = $ID";
$result = mysql_query($checkList, $connection);
$num_rows = mysql_num_rows($result);

if($num_rows == 0)
{	
	$sql = "INSERT INTO users_lists (UserID, LibraryID, AddedOn) VALUES ($UserID, $ID, NOW())";
	mysql_query($sql, $connection);
	echo("New To MyList");
}
else
{
	$sql = "DELETE FROM users_lists WHERE UserID = $UserID and LibraryID = $ID";
	mysql_query($sql, $connection);
	echo("Removed From MyList");
}

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
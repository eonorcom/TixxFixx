<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$SongID = $_POST['SongID'];
$UserID = $_SESSION['id'];

$sql = "INSERT INTO users_plays (UserID, SongID, PlayedOn) VALUES ($UserID, $SongID, NOW())";
mysql_query($sql, $connection);
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
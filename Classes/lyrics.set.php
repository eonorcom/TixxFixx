<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$LibraryID = $_POST['id'];
$Lyrics = $_POST['Lyrics'];

$UserID = $_SESSION['id'];
//update Library
$sql = "delete from song_lyrics where LibraryID = $LibraryID";

mysql_query($sql, $connection);

$insert = sprintf("insert into song_lyrics (LibraryID, Lyrics, AddedBy, AddedOn) values ('%s', '%s', '%s', NOW())",
	mysql_real_escape_string($LibraryID),
	mysql_real_escape_string($Lyrics),
	mysql_real_escape_string($UserID));
echo $insert;	
mysql_query($insert);

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
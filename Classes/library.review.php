<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$LibraryID = $_POST['LibraryID'];
$ArtistID = $_POST['ArtistID'];
$AlbumID = $_POST['AlbumID'];

$Hot200 =  $_POST['Hot200'];
$Dance500 =  $_POST['Dance500'];
$LDS100 =  $_POST['LDS100'];

$Genre1 =  $_POST['Genre1'];
$Genre2 =  $_POST['Genre2'];
$Genre3 =  $_POST['Genre3'];
$Genre4 =  $_POST['Genre4'];
$Genre5 =  $_POST['Genre5'];
$Genre6 =  $_POST['Genre6'];
$Genre7 =  $_POST['Genre7'];
$Genre8 =  $_POST['Genre8'];
$Genre9 =  $_POST['Genre9'];

$Lyrics = $_POST['Lyrics'];

$UserID = $_SESSION['id'];
//update Library
$sql = "update library set Status = 3, ApprovedBy = $UserID, ApprovedOn = NOW() where id = $LibraryID";
mysql_query($sql, $connection);

$sql = "update artist set Status = 3 where ArtistID = $ArtistID";
mysql_query($sql, $connection);

$sql = "update album set Status = 3 where AlbumID = $AlbumID";
mysql_query($sql, $connection);

//delete current genre
$sql = "delete from genre_items where LibraryID = $LibraryID";
mysql_query($sql, $connection);

if ($Lyrics != "")
{
$insert = sprintf("insert into song_lyrics (LibraryID, Lyrics, AddedBy, AddedOn) values ('%s', '%s', '%s', NOW())",
	mysql_real_escape_string($LibraryID),
	mysql_real_escape_string($Lyrics),
	mysql_real_escape_string($UserID));
echo $insert;	
mysql_query($insert);
}

if ($Genre1 == "checked")
{
	$sql = "insert into genre_items (GenreID, LibraryID) values (1, $LibraryID)";
	mysql_query($sql, $connection);
}
if ($Genre2 == "checked")
{
	$sql = "insert into genre_items (GenreID, LibraryID) values (2, $LibraryID)";
	mysql_query($sql, $connection);
}
if ($Genre3 == "checked")
{
	$sql = "insert into genre_items (GenreID, LibraryID) values (3, $LibraryID)";
	mysql_query($sql, $connection);
}
if ($Genre4 == "checked")
{
	$sql = "insert into genre_items (GenreID, LibraryID) values (4, $LibraryID)";
	mysql_query($sql, $connection);
}
if ($Genre5 == "checked")
{
	$sql = "insert into genre_items (GenreID, LibraryID) values (5, $LibraryID)";
	mysql_query($sql, $connection);
}
if ($Genre6 == "checked")
{
	$sql = "insert into genre_items (GenreID, LibraryID) values (6, $LibraryID)";
	mysql_query($sql, $connection);
}
if ($Genre7 == "checked")
{
	$sql = "insert into genre_items (GenreID, LibraryID) values (7, $LibraryID)";
	mysql_query($sql, $connection);
}
if ($Genre8 == "checked")
{
	$sql = "insert into genre_items (GenreID, LibraryID) values (8, $LibraryID)";
	mysql_query($sql, $connection);
}
if ($Genre9 == "checked")
{
	$sql = "insert into genre_items (GenreID, LibraryID) values (9, $LibraryID)";
	mysql_query($sql, $connection);
}

//insert charts
$sql = "delete from charts_items where LibraryID = $LibraryID";
mysql_query($sql, $connection);

if ($Hot200 == "checked")
{
	$sql = "insert into charts_items (ChartID, LibraryID) values (1, $LibraryID)";
	mysql_query($sql, $connection);	
}
if ($Dance500 == "checked")
{
	$sql = "insert into charts_items (ChartID, LibraryID) values (2, $LibraryID)";
	mysql_query($sql, $connection);	
}
if ($LDS100 == "checked")
{
	$sql = "insert into charts_items (ChartID, LibraryID) values (3, $LibraryID)";
	mysql_query($sql, $connection);	
}
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
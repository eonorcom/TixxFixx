<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$ID = $_POST['ID'];
$Vote = $_POST['Vote'];
$Type = $_POST['Type'];
$TypeID = $_POST['TypeID'];
$UserID = $_SESSION['id'];


if ($Type == "Chart")
{
	$checkVoteSql = "select * from users_votes where UserID = $UserID and LibraryID = $ID and Type = '$Type' and TypeID = '$TypeID'";
	$result = mysql_query($checkVoteSql, $connection);
	$num_rows = mysql_num_rows($result);		
}


$checkVoteSql = "select * from users_votes where UserID = $UserID and LibraryID = $ID";
$result = mysql_query($checkVoteSql, $connection);
$num_rows = mysql_num_rows($result);

if($num_rows == 0)
{
	if ($Vote == 1)
	{
		$voteSql = "Update Library set Likes = Likes + 1 where ID = $ID";
		$userSql = "INSERT INTO users_votes (UserID, LibraryID, Vote, Type, TypeID, DateVoted) VALUES ($UserID, $ID, 3, '$Type', $TypeID, NOW())";
	}
	
	if ($Vote == 0)
	{
		$voteSql = "Update Library set Hates = Hates + 1 where ID = $ID";
		$userSql = "INSERT INTO users_votes (UserID, LibraryID, Vote, Type, TypeID, DateVoted) VALUES ($UserID, $ID, 1, '$Type', $TypeID, NOW())";
	}
	mysql_query($voteSql, $connection);	
	mysql_query($userSql, $connection);
	echo("New Vote");
}
else
{
	if ($Vote == 1)
	{
		$voteSql = "Update Library set Likes = Likes + 1, Hates = Hates - 1, Type = '$Type', TypeID = $Type where ID = $ID";
		$userSql = "update users_votes set Vote = 3 where UserID = $UserID and LibraryID = $ID";
	}
	
	if ($Vote == 0)
	{
		$voteSql = "Update Library set Hates = Hates + 1, Likes = Likes - 1, Type = '$Type', TypeID = $Type where ID = $ID";
		$userSql = "update users_votes set Vote = 1 where UserID = $UserID and LibraryID = $ID";
	}
	mysql_query($voteSql, $connection);
	
	mysql_query($userSql, $connection);
	
	echo("Changed Vote");
}

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
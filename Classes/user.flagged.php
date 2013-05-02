<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$ID = $_POST['ID'];
$UserID = $_SESSION['id'];

$Reason1 =  $_POST['Reason1'];
$Reason2 =  $_POST['Reason2'];
$Reason3 =  $_POST['Reason3'];
$Reason4 =  $_POST['Reason4'];
$Reason5 =  $_POST['Reason5'];
$Reason6 =  $_POST['Reason6'];
$Reason7 =  $_POST['Reason7'];
$Reason8 =  $_POST['Reason8'];
$Reason9 =  $_POST['Reason9'];

$Reason = "";

if ($Reason1 == "checked")
{
	$Reason .= "Evil and Destructive Messagese,";
}

if ($Reason2 == "checked")
{
	$Reason .= "Encourages Immorality,";
}

if ($Reason3 == "checked")
{
	$Reason .= "Glorifies Violence,";
}

if ($Reason4 == "checked")
{
	$Reason .= "Vulgar or Offensive Language,";
}

if ($Reason5 == "checked")
{
	$Reason .= "Promotes Evil Practices,";
}

if ($Reason6 == "checked")
{
	$Reason .= "References to Drugs or Alcohol,";
}

if ($Reason7 == "checked")
{
	$Reason = "0,";
}

if ($Reason8 == "checked")
{
	$Reason = "0,";
}

if ($Reason9 == "checked")
{
	$Reason = "0,";
}

$Reason = rtrim($Reason, ",");

$checkList = "select * from flagged where UserID = $UserID and LibraryID = $ID";
$result = mysql_query($checkList, $connection);
$num_rows = mysql_num_rows($result);

if($num_rows == 0)
{	
	$sql = "INSERT INTO flagged (UserID, LibraryID, FlaggedOn, Reason) VALUES ($UserID, $ID, NOW(), '$Reason')";
	echo "$sql\n\n";
	mysql_query($sql, $connection);
	
	
	$sql = "UPDATE library SET Status = 5 WHERE id = $ID";
	echo $sql;
	mysql_query($sql, $connection);
}
else
{
	$sql = "DELETE FROM flagged WHERE UserID = $UserID and LibraryID = $ID";
	mysql_query($sql, $connection);
	echo("Removed Flag");
	
	
	$sql = "UPDATE library SET Status = 3 WHERE id = $ID";
	echo $sql;
	mysql_query($sql, $connection);
}

?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
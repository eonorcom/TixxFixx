<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$UserID = $_SESSION['id'];

$FirstName = $_POST['FirstName'];
$LastName = $_POST['LastName'];
$Address1 = $_POST['Address1'];
$Address2 = $_POST['Address2'];
$City = $_POST['City'];
$State = $_POST['State'];
$Zip = $_POST['Zip'];
$Phone = $_POST['Phone'];
$Email = $_POST['Email'];

	 

$update = sprintf("update user_info set EndDate = NOW() where UserID = '%s' and EndDate is null",
		mysql_real_escape_string($UserID));
$result = mysql_query($update);

	$insert = sprintf("insert into user_info (UserID, FirstName, LastName, Address1, Address2, City, State, Zip, Phone, Email, StartDate, EndDate) values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW(), null)",
		mysql_real_escape_string($UserID),
		mysql_real_escape_string($FirstName),
		mysql_real_escape_string($LastName),
		mysql_real_escape_string($Address1),
		mysql_real_escape_string($Address2),
		mysql_real_escape_string($City),
		mysql_real_escape_string($State),
		mysql_real_escape_string($Zip),
		mysql_real_escape_string($Phone),
		mysql_real_escape_string($Email),
		mysql_real_escape_string($LastUpdated));
	echo $insert;	
	mysql_query($insert);


?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
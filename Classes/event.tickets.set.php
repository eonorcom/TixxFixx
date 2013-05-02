<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$JSON = json_decode($_POST['JSON'],true);
$UserID = $_SESSION['id'];
$eTixx = $_POST['eTixx'];
$FedEx = $_POST['FedEx'];
$WillCall = $_POST['WillCall'];
$Contact = $_POST['Contact'];

foreach ($JSON as $key => $value) {
	 $EventID = $JSON[$key]["EventID"];
	 $TicketType = $JSON[$key]["TicketType"];
	 $Description = $JSON[$key]["Description"];
	 $Section = $JSON[$key]["Section"];
	 $Row = $JSON[$key]["Row"];
	 $Seats = $JSON[$key]["Seats"];
	 $Qty = $JSON[$key]["Qty"];
	 $Price = $JSON[$key]["Price"];
	 $Splits = $JSON[$key]["Splits"];
	 $AdditionalInfo = $JSON[$key]["AdditionalInfo"];
	 
	$insert = sprintf("insert into tickets (EventID, UserID, TicketType, TicketDesc, Section, Row, Seats, Qty, Price, Splits, AdditionalInfo, eTixx, FedEx, WillCall, Contact, AddedOn, AddedBy) values ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW(), '%s')",
		mysql_real_escape_string($EventID),
		mysql_real_escape_string($UserID),
		mysql_real_escape_string($TicketType),
		mysql_real_escape_string($Description),
		mysql_real_escape_string($Section),
		mysql_real_escape_string($Row),
		mysql_real_escape_string($Seats),
		mysql_real_escape_string($Qty),
		mysql_real_escape_string($Price),
		mysql_real_escape_string($Splits),
		mysql_real_escape_string($AdditionalInfo),
		mysql_real_escape_string($eTixx),
		mysql_real_escape_string($FedEx),
		mysql_real_escape_string($WillCall),
		mysql_real_escape_string($Contact),
		mysql_real_escape_string($UserID));
	
	echo $insert;	
	mysql_query($insert);

}



?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
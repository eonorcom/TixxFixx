<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$id = $_GET['id'];
$sql = "select 
			Lyrics,
	        u.id as UserID, 
			username,
			fullname,
			AddedOn
		from 
			song_lyrics l
			inner join users u on l.AddedBy = u.id
		where 
			LibraryID = $id";

$rs = mysql_query($sql, $connection);
while($obj = mysql_fetch_object($rs)) {
	$arr[] = $obj;
}

//echo "$sql\n";
//print_r($arr);
echo '{"lyrics":'.json_encode($arr).'}';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
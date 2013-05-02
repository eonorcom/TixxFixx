<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php

$sql = "select
		  l.id,
		  SongID, 
		  SongName,      
				ArtistName,
				u.id as UserID,
				IFNULL(u.fullname, u.username) as fullname,
		  Reason,
		  f.FlaggedOn
			from
				library l
				inner join artist a on l.ArtistID = a.ArtistID      
				inner join flagged f on l.id = f.LibraryID
				inner join users u on f.UserID = u.id
			where
				l.status = 5	
				and IFNULL(Reason, '') <> '0'   
			order by
				SongName ASC
		";

$rs = mysql_query($sql, $connection);
while($obj = mysql_fetch_object($rs)) {
	$arr[] = $obj;
}

//echo "$sql\n";
//print_r($arr);
echo '{"blacklist":'.json_encode($arr).'}';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
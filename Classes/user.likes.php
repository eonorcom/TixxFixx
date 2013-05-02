<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php

$ID = $_GET['ID'];

	$sql = "select
				id,
				oauth_provider as Source,
				oauth_uid as SourceID,
				email,
				username,
				IFNULL(fullname, username) as fullname,
				IFNULL(location, '') as location,
				profile_image,
				IFNULL(LastLogin, '') as LastLogin
			from
				users u
				inner join users_votes v on u.id = v.UserID
			where
				LibraryID = $ID
				and Vote = 3
			order by
				LastLogin DESC
			limit 15";
	$rs = mysql_query($sql, $connection);
	
	while($obj = mysql_fetch_object($rs)) {
		$arr[] = $obj;
	}
	 
	echo '{"users":'.json_encode($arr).'}';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
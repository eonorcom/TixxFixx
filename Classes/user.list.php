<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$sql = "select
			id,
			oauth_provider as Source,
			oauth_uid as SourceID,
			email,
			username,
			IFNULL(fullname, username) as fullname,
			IFNULL(location, '') as location,
			profile_image,
			IFNULL(LastLogin, '') as LastLogin,
			(select count(*) from library where SubmittedBy = u.id) as SongsSuggested,    
			(select count(*) from users_votes where UserID = u.id) as Votes,
			(select count(*) from users_votes where UserID = u.id and Vote = 3) as Likes,
			(select count(*) from users_votes where UserID = u.id and Vote = 1) as Hates,
			(select count(*) from library where ApprovedBy = u.id) as SongsReviewed,  
			contributor
		from
			users u
		order by
			LastLogin DESC
		limit 50";
$rs = mysql_query($sql, $connection);

while($obj = mysql_fetch_object($rs)) {
	$arr[] = $obj;
}
 
echo '{"users":'.json_encode($arr).'}';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
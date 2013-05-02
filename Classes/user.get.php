<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$UserID = $_GET["ID"];
if ($UserID == "")
{
	$UserID = $_SESSION['id'];
}
	$sql = sprintf("select 
					id,
					oauth_provider as Source,
					oauth_uid as SourceID,
					email,
					username,
					IFNULL(fullname, username) as fullname,
					IFNULL(location, '') as location,
					profile_image,
					IFNULL(LastLogin, '') as LastLogin, 
					(select count(*) from users_lists where UserID = u.id) as Favorites,
					(select count(*) from library l inner join users_votes v on l.id = v.LibraryID where l.Status = 3 and v.UserID = u.id) as Votes,
					(select count(*) from library l inner join users_votes v on l.id = v.LibraryID where l.Status = 3 and v.UserID = u.id and Vote = 3) as Likes,
					(select count(*) from library l inner join users_votes v on l.id = v.LibraryID where l.Status = 3 and v.UserID = u.id and Vote = 1) as Hates,
					(select count(*) from library where SubmittedBy = u.id and Status = 3) as SongsSuggested,    
					(select count(*) from library where ApprovedBy = u.id and Status = 3) as SongsReviewed
				from 
					users u
				where 
					id = '%s'", 
				mysql_real_escape_string($UserID));
	$rs = mysql_query($sql, $connection);
	
	while($obj = mysql_fetch_object($rs)) {
		$arr[] = $obj;
	}
	 
	echo '{"profile":'.json_encode($arr).'}';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
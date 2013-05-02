<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
session_start();

$Status = $_GET['Status'];
$Value = $_GET['Value'];
$Type = $_GET['Type'];

$ProfileUserID = $_GET['UserID'];
$UserID = $_SESSION['id'];
if ($UserID == "")
{
	$UserID = 0;
}

$arr = array();

// Status:
// 1 = Pending, 3 = Approved, 5 = Removed

if ($Type == "chart")
{
	$limit = 200;
	
	if ($Value == 2)
	{
		$limit = 500;
	}
	
	if ($Value == 3)
	{
		$limit = 100;
	}
	
	$sql = "select
				l.*,
				ArtistName,
				AlbumName,
				u.id as UserID,
				u.oauth_provider as Source,
				IFNULL(u.fullname, u.username) as fullname,
				(l.Likes + l.Hates) as Votes,
				IFNULL((select Vote from users_votes where LibraryID = l.ID and UserID = $UserID),0) as Vote,
				(select count(*) from users_lists where LibraryID = l.ID and UserID = $UserID) as MyList,
				IFNULL((select group_concat(Chart) from charts_items i inner join charts c on i.ChartID = c.ID where LibraryID = l.ID group by LibraryID), '') as Charts,
				IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
				(select count(*) from song_lyrics where LibraryID = l.ID) as Lyrics,
    (500 + (select (count(*) * 3) from users_lists where LibraryID = l.id) + 
           (select (count(*) * 2) from users_plays where SongID = l.SongID) - 
           (select count(*) from users_votes where Vote = 1 and LibraryID = l.id) + 
           (select (count(*) * 2) from users_votes where Vote = 3 and LibraryID = l.id) + 
           (SELECT (365 + DATEDIFF(ApprovedOn, NOW())) from Library where ID = l.id)) as Rating
			from
				library l
				inner join artist a on l.ArtistID = a.ArtistID
				inner join album b on l.AlbumID = b.AlbumID
				inner join charts_items c on l.ID = c.LibraryID	
				inner join users u on l.SubmittedBy = u.id
			where
				c.ChartID = $Value
				and l.status = 3
				and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)
			order by
				Rating DESC, ApprovedOn DESC
			Limit $limit";
}
if ($Type == "genre")
{
	$sql = "select
				l.*,
				ArtistName,
				AlbumName,
				u.id as UserID,
				u.oauth_provider as Source,
				IFNULL(u.fullname, u.username) as fullname,
				(l.Likes + l.Hates) as Votes,
				IFNULL((select Vote from users_votes where LibraryID = l.ID and UserID = $UserID),0) as Vote,
				(select count(*) from users_lists where LibraryID = l.ID and UserID = $UserID) as MyList,
				IFNULL((select group_concat(Chart) from charts_items i inner join charts c on i.ChartID = c.ID where LibraryID = l.ID group by LibraryID), '') as Charts,
				IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
				(select count(*) from song_lyrics where LibraryID = l.ID) as Lyrics,
    (500 + (select (count(*) * 3) from users_lists where LibraryID = l.id) + 
           (select (count(*) * 2) from users_plays where SongID = l.SongID) - 
           (select count(*) from users_votes where Vote = 1 and LibraryID = l.id) + 
           (select (count(*) * 2) from users_votes where Vote = 3 and LibraryID = l.id) + 
           (SELECT (365 + DATEDIFF(ApprovedOn, NOW())) from Library where ID = l.id)) as Rating
			from
				library l
				inner join artist a on l.ArtistID = a.ArtistID
				inner join album b on l.AlbumID = b.AlbumID
				inner join genre_items g on l.ID = g.LibraryID	
				inner join users u on l.SubmittedBy = u.id
			where
				g.GenreID = $Value
				and l.status = 3
				and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)
			order by
				Rating DESC, ApprovedOn DESC
			Limit 200";
}
if ($Type == "suggestions")
{
	$sql = "select
				l.*,
				ArtistName,
				AlbumName,
				u.id as UserID,
				u.oauth_provider as Source,
				IFNULL(u.fullname, u.username) as fullname,
				IFNULL((select group_concat(Chart) from charts_items i inner join charts c on i.ChartID = c.ID where LibraryID = l.ID group by LibraryID), '') as Charts,
				IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
				IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
				(select count(*) from song_lyrics where LibraryID = l.ID) as Lyrics
			from
				library l
				inner join artist a on l.ArtistID = a.ArtistID
				inner join album b on l.AlbumID = b.AlbumID            
				inner join users u on l.SubmittedBy = u.id
			where
				l.status = 1				
				and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)
				and l.ID not in (select LibraryID from users_votes where LibraryID = l.ID and UserID = $UserID)
				and Hates < 3
				and (SubmittedBy in (1,2,11,16) or SubmittedBy <> $UserID)
			order by
				SubmittedOn ASC
			Limit 200";
	
}
if ($Type == "mylist")
{
	if ($Value == 1)
	{
		$sql = "select
			l.*,
			ArtistName,
			AlbumName,
			u.id as UserID,
			u.oauth_provider as Source,
			IFNULL(u.fullname, u.username) as fullname,
			(l.Likes + l.Hates) as Votes,
			IFNULL((select Vote from users_votes where LibraryID = l.ID and UserID = $UserID),0) as Vote,
			1 as MyList,
			IFNULL((select group_concat(Chart) from charts_items i inner join charts c on i.ChartID = c.ID where LibraryID = l.ID group by LibraryID), '') as Charts,
			IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
				(select count(*) from song_lyrics where LibraryID = l.ID) as Lyrics,
    (500 + (select (count(*) * 3) from users_lists where LibraryID = l.id) + 
           (select (count(*) * 2) from users_plays where SongID = l.SongID) - 
           (select count(*) from users_votes where Vote = 1 and LibraryID = l.id) + 
           (select (count(*) * 2) from users_votes where Vote = 3 and LibraryID = l.id) + 
           (SELECT (365 + DATEDIFF(ApprovedOn, NOW())) from Library where ID = l.id)) as Rating
		from
			library l
			inner join artist a on l.ArtistID = a.ArtistID
			inner join album b on l.AlbumID = b.AlbumID
			inner join users u on l.SubmittedBy = u.id
			inner join users_lists ul on l.ID = ul.LibraryID	
		where
			ul.UserID = $ProfileUserID
			and l.status = 3
			and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)
		order by
			Rating DESC, ApprovedOn DESC
		Limit 200";
	}
	if ($Value == 2)
	{
		$sql = "select
			l.*,
			ArtistName,
			AlbumName,
			u.id as UserID,
			u.oauth_provider as Source,
			IFNULL(u.fullname, u.username) as fullname,
			(l.Likes + l.Hates) as Votes,
			IFNULL((select Vote from users_votes where LibraryID = l.ID and UserID = $UserID),0) as Vote,
			1 as MyList,
			IFNULL((select group_concat(Chart) from charts_items i inner join charts c on i.ChartID = c.ID where LibraryID = l.ID group by LibraryID), '') as Charts,
			IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
				(select count(*) from song_lyrics where LibraryID = l.ID) as Lyrics,
    (500 + (select (count(*) * 3) from users_lists where LibraryID = l.id) + 
           (select (count(*) * 2) from users_plays where SongID = l.SongID) - 
           (select count(*) from users_votes where Vote = 1 and LibraryID = l.id) + 
           (select (count(*) * 2) from users_votes where Vote = 3 and LibraryID = l.id) + 
           (SELECT (365 + DATEDIFF(ApprovedOn, NOW())) from Library where ID = l.id)) as Rating
		from
			library l
			inner join artist a on l.ArtistID = a.ArtistID
			inner join album b on l.AlbumID = b.AlbumID
			inner join users u on l.SubmittedBy = u.id
			inner join users_votes ul on l.ID = ul.LibraryID	
		where
			ul.UserID = $ProfileUserID
			and ul.Vote = 3
			and l.status = 3
			and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)
		order by
			Rating DESC, ApprovedOn DESC
		Limit 200";
	}
	if ($Value == 3)
	{
		$sql = "select
			l.*,
			ArtistName,
			AlbumName,
			u.id as UserID,
			u.oauth_provider as Source,
			IFNULL(u.fullname, u.username) as fullname,
			(l.Likes + l.Hates) as Votes,
			IFNULL((select Vote from users_votes where LibraryID = l.ID and UserID = $UserID),0) as Vote,
			1 as MyList,
			IFNULL((select group_concat(Chart) from charts_items i inner join charts c on i.ChartID = c.ID where LibraryID = l.ID group by LibraryID), '') as Charts,
			IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
				(select count(*) from song_lyrics where LibraryID = l.ID) as Lyrics,
    (500 + (select (count(*) * 3) from users_lists where LibraryID = l.id) + 
           (select (count(*) * 2) from users_plays where SongID = l.SongID) - 
           (select count(*) from users_votes where Vote = 1 and LibraryID = l.id) + 
           (select (count(*) * 2) from users_votes where Vote = 3 and LibraryID = l.id) + 
           (SELECT (365 + DATEDIFF(ApprovedOn, NOW())) from Library where ID = l.id)) as Rating
		from
			library l
			inner join artist a on l.ArtistID = a.ArtistID
			inner join album b on l.AlbumID = b.AlbumID
			inner join users u on l.SubmittedBy = u.id
			inner join users_votes ul on l.ID = ul.LibraryID	
		where
			ul.UserID = $ProfileUserID
			and ul.Vote = 1
			and l.status = 3
			and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)
		order by
			Rating DESC, ApprovedOn DESC
		Limit 200";
	}
	if ($Value == 4)
	{
		$sql = "select
			l.*,
			ArtistName,
			AlbumName,
			u.id as UserID,
			u.oauth_provider as Source,
			IFNULL(u.fullname, u.username) as fullname,
			(l.Likes + l.Hates) as Votes,
			IFNULL((select Vote from users_votes where LibraryID = l.ID and UserID = $UserID),0) as Vote,
			1 as MyList,
			IFNULL((select group_concat(Chart) from charts_items i inner join charts c on i.ChartID = c.ID where LibraryID = l.ID group by LibraryID), '') as Charts,
			IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
				(select count(*) from song_lyrics where LibraryID = l.ID) as Lyrics,
    (500 + (select (count(*) * 3) from users_lists where LibraryID = l.id) + 
           (select (count(*) * 2) from users_plays where SongID = l.SongID) - 
           (select count(*) from users_votes where Vote = 1 and LibraryID = l.id) + 
           (select (count(*) * 2) from users_votes where Vote = 3 and LibraryID = l.id) + 
           (SELECT (365 + DATEDIFF(ApprovedOn, NOW())) from Library where ID = l.id)) as Rating
		from
			library l
			inner join artist a on l.ArtistID = a.ArtistID
			inner join album b on l.AlbumID = b.AlbumID
			inner join users u on l.SubmittedBy = u.id
		where
			l.SubmittedBy = $ProfileUserID
			and l.status = 3
			and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)
		order by
			Rating DESC, ApprovedOn DESC
		Limit 200";
	}
	if ($Value == 5)
	{
		$sql = "select
			l.*,
			ArtistName,
			AlbumName,
			u.id as UserID,
			u.oauth_provider as Source,
			IFNULL(u.fullname, u.username) as fullname,
			(l.Likes + l.Hates) as Votes,
			IFNULL((select Vote from users_votes where LibraryID = l.ID and UserID = $UserID),0) as Vote,
			1 as MyList,
			IFNULL((select group_concat(Chart) from charts_items i inner join charts c on i.ChartID = c.ID where LibraryID = l.ID group by LibraryID), '') as Charts,
			IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
				(select count(*) from song_lyrics where LibraryID = l.ID) as Lyrics,
    (500 + (select (count(*) * 3) from users_lists where LibraryID = l.id) + 
           (select (count(*) * 2) from users_plays where SongID = l.SongID) - 
           (select count(*) from users_votes where Vote = 1 and LibraryID = l.id) + 
           (select (count(*) * 2) from users_votes where Vote = 3 and LibraryID = l.id) + 
           (SELECT (365 + DATEDIFF(ApprovedOn, NOW())) from Library where ID = l.id)) as Rating
		from
			library l
			inner join artist a on l.ArtistID = a.ArtistID
			inner join album b on l.AlbumID = b.AlbumID
			inner join users u on l.SubmittedBy = u.id
		where
			l.ApprovedBy = $ProfileUserID
			and l.status = 3
			and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)
		order by
			Rating DESC, ApprovedOn DESC
		Limit 200";
	}
	
}
if ($Type == "search")
{
	$sql = "select
			l.*,
			ArtistName,
			AlbumName,
			u.id as UserID,
			u.oauth_provider as Source,
			IFNULL(u.fullname, u.username) as fullname,
			(l.Likes + l.Hates) as Votes,
			IFNULL((select Vote from users_votes where LibraryID = l.ID and UserID = $UserID),0) as Vote,
			(select count(*) from users_lists where LibraryID = l.ID and UserID = $UserID) as MyList,
			IFNULL((select group_concat(Chart) from charts_items i inner join charts c on i.ChartID = c.ID where LibraryID = l.ID group by LibraryID), '') as Charts,
			IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
				(select count(*) from song_lyrics where LibraryID = l.ID) as Lyrics,
    (500 + (select (count(*) * 3) from users_lists where LibraryID = l.id) + 
           (select (count(*) * 2) from users_plays where SongID = l.SongID) - 
           (select count(*) from users_votes where Vote = 1 and LibraryID = l.id) + 
           (select (count(*) * 2) from users_votes where Vote = 3 and LibraryID = l.id) + 
           (SELECT (365 + DATEDIFF(ApprovedOn, NOW())) from Library where ID = l.id)) as Rating
		from
			library l
			inner join artist a on l.ArtistID = a.ArtistID
			inner join album b on l.AlbumID = b.AlbumID   
			inner join users u on l.SubmittedBy = u.id
		where
			l.status = 3
			and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)
			and (SongName like '%".mysql_real_escape_string($Value)."%' || ArtistName like '%".mysql_real_escape_string($Value)."%')
		order by
			Rating DESC, ApprovedOn DESC
		Limit 200";
}
$rs = mysql_query($sql, $connection);
while($obj = mysql_fetch_object($rs)) {
	$arr[] = $obj;
}

//echo "$sql\n";
//print_r($arr);


if ($Type == "search")
{
		
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
				and (SongName like '%".mysql_real_escape_string($Value)."%' || ArtistName like '%".mysql_real_escape_string($Value)."%')
			order by
				SongName ASC";
		
		$rs = mysql_query($sql, $connection);
		while($obj = mysql_fetch_object($rs)) {
			$blacklist[] = $obj;
		}
}
else
{
	$blacklist = "";
}

echo '{"library":'.json_encode($arr).', "blacklist":'.json_encode($blacklist).'}';
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
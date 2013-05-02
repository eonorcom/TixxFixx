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

	
	$sql = "select distinct
				l.*,
				ArtistName,
				AlbumName,
				u.id as UserID,
				u.oauth_provider as Source,
				IFNULL(u.fullname, u.username) as fullname,
				(l.Likes + l.Hates) as Votes,
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
				l.status = 3
				and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)
			order by
				Rating DESC, ApprovedOn DESC";
		
$result  = mysql_query($sql, $connection);




header("Content-type: text/xml");
$XML = "<?xml version=\"1.0\"?>\n";
if ($xslt_file) $XML .= "<?xml-stylesheet href=\"$xslt_file\" type=\"text/xsl\" ?>";
 
// root node
$XML .= "<result>\n";
// rows
while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {    
  $XML .= "\t<row>\n"; 
  $i = 0;
  // cells
  foreach ($row as $cell) {
    // Escaping illegal characters - not tested actually ;)
    $cell = str_replace("&", "&amp;", $cell);
    $cell = str_replace("<", "&lt;", $cell);
    $cell = str_replace(">", "&gt;", $cell);
    $cell = str_replace("\"", "&quot;", $cell);
    $col_name = mysql_field_name($result,$i);
    // creates the "<tag>contents</tag>" representing the column
    $XML .= "\t\t<" . $col_name . ">" . $cell . "</" . $col_name . ">\n";
    $i++;
  }
  $XML .= "\t</row>\n"; 
 }
$XML .= "</result>\n";
 
// output the whole XML string
echo $XML;
?>
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/cleanup.php");  ?>
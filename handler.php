<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php

//Always place this code at the top of the Page
session_start();

$path = explode('/', $_SERVER['REQUEST_URI']);
$artist = str_replace("-", " ", $path[1]);
$song = str_replace("-", " ", $path[2]);
$SongID = $path[3];


if (isset($SongID)) 
{
	$sql = sprintf("select
					l.*,
					ArtistName,
					AlbumName,
					u.id as UserID,
					u.oauth_provider as Source,
					IFNULL(u.fullname, u.username) as fullname,
					(l.Likes + l.Hates) as Votes,
					((l.Likes * 2) - l.Hates) as Rating,
					IFNULL((select group_concat(Chart) from charts_items i inner join charts c on i.ChartID = c.ID where LibraryID = l.ID group by LibraryID), '') as Charts,
					IFNULL((select group_concat(genre) from genre_items i inner join genre g on i.GenreID = g.ID where LibraryID = l.ID group by LibraryID), '') as Genres,
					(select count(*) from song_lyrics where LibraryID = l.ID) as Lyrics
				from
					library l
					inner join artist a on l.ArtistID = a.ArtistID
					inner join album b on l.AlbumID = b.AlbumID
					inner join charts_items c on l.ID = c.LibraryID	
					inner join users u on l.SubmittedBy = u.id
				where
					l.SongID = '%s' 
					and l.status = 3
					and l.ID not in (select LibraryID from flagged where LibraryID = l.ID)",
				mysql_real_escape_string($SongID));	
				
	$result = mysql_query($sql, $connection);
	$row = mysql_fetch_array($result);
	
	$ID = $row['id'];
	$SongID = $row['SongID'];
	$SongName = $row['SongName'];
	$ArtistID = $row['ArtistID'];
	$AlbumID = $row['AlbumID'];
	$TinySong = $row['TinySong'];
	$Status = $row['Status'];
	$LastLogin = $row['LastLogin'];
	$SubmittedBy = $row['SubmittedBy'];
	$SubmittedOn = $row['SubmittedOn'];
	$ApprovedBy = $row['ApprovedBy'];
	$ApprovedOn = $row['ApprovedOn'];
	$Likes = $row['Likes'];
	$Hates = $row['Hates'];
	$ArtistName = $row['ArtistName'];
	$UserID = $row['UserID'];
	$Source = $row['Source'];
	$fullname = $row['fullname'];
	$Votes = $row['Votes'];
	$Rating = $row['Rating'];
	$Charts = $row['Charts'];
	$Genres = $row['Genres'];
	$Lyrics = $row['Lyrics'];
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title><?php echo $SongName ?> by <?php echo $ArtistName ?> on TixxFixx.com</title>
    <meta name="keywords" content="<?php echo $_SESSION['location'] ?>,  events,  concerts,  tickets,  concert tickets, buy  tickets, sell  tickets, trade  tickets">
    <meta name="description" content="TixxFixx  - Your Ticket Solution- Your place to buy, sell, trade, consign or upgrade your event or concert tickets.">

  
  
    <meta http-equiv="Content-Type" 		content="text/html; charset=utf-8" />
    <meta mame="AUTHOR" 					content="Ryan Riley - TixxFixx.com">
    <meta mame="COPYRIGHT"					content="&copy; 2012 TixxFixx.com">
    
    <meta http-equiv="CACHE-CONTROL" 		content="NO-CACHE">
    <meta http-equiv="CONTENT-LANGUAGE" 	content="en-US">
    <meta mame="ROBOTS" 					content="INDEX,FOLLOW">
    
    <meta property="fb:app_id"      		content="435317736521241" /> 
    <meta property="og:type"        		content="tixxfixx:music" /> 
    <meta property="og:title"       		content="<?php echo $SongName ?> by <?php echo $ArtistName ?> on TixxFixx.com" /> 
    <meta property="og:description" 		content="Listen to <?php echo $SongName ?> by <?php echo $ArtistName ?> on TixxFixx.com - your source for music you can listen to!" /> 
    <meta property="og:url"         		content="http://www.tixxfixx.com<?php echo $_SERVER['REQUEST_URI'] ?>" /> 
    <meta property="og:image"       		content="http://www.tixxfixx.com/Classes/images.cache.php?id=<?php echo $AlbumID ?>&size=m&refresh=false&url=http://beta.grooveshark.com/static/amazonart/m<?php echo $AlbumID ?>.jpg" /> 
    
    <script>
		SESSION = { 
			"id": "<?php echo $_SESSION["id"]; ?>",
		};
	</script>

    
    <link rel="stylesheet" href="/include/css/style.css" type="text/css">    
	
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>    
	<script type="text/javascript" src="/include/js/jquery.min.js"></script>
    <script type="text/javascript" src="/include/js/jquery.timeago.js"></script>
    <script type="text/javascript" src="/include/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/include/js/jquery.querystring.js"></script>
    <script type="text/javascript" src="/include/js/jquery.address-1.4.min.js?strict=false&wrap=true"></script>   
	<script type="text/javascript" src="/include/js/jquery.dateFormat.js"></script>         
    <script type="text/javascript" src="/include/js/verbage/txt-section-header.js"></script>
    <script type="text/javascript" src="/include/js/verbage/txt-list-smack.js"></script>
    <script type="text/javascript" src="/include/js/script.js"></script>    
    <script type="text/javascript" src="/include/swfobject/swfobject.js"></script>  
    
	<script type="text/javascript">
		
		var _gaq = _gaq || [];
		_gaq.push(['_setAccount', 'UA-17228743-1']);
		_gaq.push(['_setDomainName', 'tixxfixx.com']);
		_gaq.push(['_setAllowLinker', true]);
		_gaq.push(['_trackPageview']);
		
		(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
		})();
		
		
		<?php 
		if (isset($SongID)) 
		{
		?>
			$.cookie("show", 0);
		<?php 
		}
		else
		{
		?>
			$.cookie("value", 1);
			$.cookie("type", "chart");
			$.cookie("show", 1);
		<?php 
		}
		?>
		
		(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=435317736521241";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
</head>
<body>
    <div id="fb-root"></div>

	<div id="chart-temp">
        <div class="hidden" id="LibraryID-<?php echo $ID ?>"><?php echo $ID ?></div>
        <div class="hidden" id="SongID-<?php echo $ID ?>"><?php echo $SongID ?></div>
        <div class="hidden" id="SongName-<?php echo $ID ?>"><?php echo $SongName ?></div>
        <div class="hidden" id="ArtistID-<?php echo $ID ?>"><?php echo $ArtistID ?></div>
        <div class="hidden" id="ArtistName-<?php echo $ID ?>"><?php echo $ArtistName ?></div>
        <div class="hidden" id="AlbumID-<?php echo $ID ?>"><?php echo $AlbumID ?></div>
        <div class="hidden" id="AlbumName-<?php echo $ID ?>"><?php echo $AlbumName ?></div>
        <div class="hidden" id="Album-<?php echo $ID ?>"><?php echo $Album ?></div>
        <div class="hidden" id="TinySong-<?php echo $ID ?>"><?php echo $TinySong ?></div>
        <div class="hidden" id="SubmittedBy-<?php echo $ID ?>"><?php echo $UserID ?></div>
        <div class="hidden" id="SubmittedOn-<?php echo $ID ?>"><?php echo $SubmittedOn ?></div>
        <div class="hidden" id="Rating-<?php echo $ID ?>"><?php echo $Rating ?></div>
        <div class="hidden" id="Likes-<?php echo $ID ?>"><?php echo $Likes ?></div>
        <div class="hidden" id="Hates-<?php echo $ID ?>"><?php echo $Hates ?></div>
        <div class="hidden" id="Thumb-<?php echo $ID ?>"><?php echo $Thumb ?></div>
        <div class="hidden" id="UserID-<?php echo $ID ?>"><?php echo $UserID ?></div>
        <div class="hidden" id="Source-<?php echo $ID ?>"><?php echo $Source ?></div>
        <div class="hidden" id="Username-<?php echo $ID ?>"><?php echo $fullname ?></div>
        <div class="hidden" id="Charts-<?php echo $ID ?>"><?php echo $Charts ?></div>
        <div class="hidden" id="Genres-<?php echo $ID ?>"><?php echo $Genres ?></div>
	</div>

	
	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/header.php");  ?>

	<div id="container_page">
    
    	<div id="content_page">
    		
			<div id="social">
            	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/social.php");  ?>            	
	        </div>

    		<div id="logo"><img src="/images/logo.png" width="206" height="121" /></div>
            
            <div id="contet_body">
            	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/events.php");  ?>         
            </div>
            
		</div>   
    
   		<div id="footer" style="margin: -198px 0 0; padding: 358px 0 0;"><?php include($_SERVER['DOCUMENT_ROOT']."/include/template/footer.php");  ?></div>	
    </div>
    
    
	<script>
		<?php 
		if (isset($SongID)) 
		{
		?>
			songComments(<?php echo $ID ?>)
		<?php 
		}
		?>
	</script>
</body>
</html>


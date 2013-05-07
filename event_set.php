<?php
include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  

//Always place this code at the top of the Page
session_start();
$Debug = "false";
$EditEvent = 0;
$EventID = $_GET['ID'];
						
$Namespace = "";
$MarketID = "";
$VenueID = "";
$Title = "";
$Description = "";
$Free = "";
$Price = "";
$Tickets = "";

$StartTime = new DateTime();
$StopTime = new DateTime();
$Created = new DateTime();

$EventUrl = "";
$VenueUrl = "";

$ShareUrl = "";

$VenueName = "";
$Address = "";
$City = "";
$Region = "";
$PostalCode = "";
$Country = "";
$Latitude = "";
$Longitude = "";



if ($EventID != "")
{
	$sql = "select 
			Namespace,
			e.*,
			v.Name as VenueName,
			v.Address,
			v.City,
			v.Region,
			v.PostalCode,
			v.Country,
			v.Latitude,
			v.Longitude,
			v.Source as VenueSource,
			v.SourceURL as VenueSourceUrl,
			(select count(*) from tickets where EventID = e.EventID) as Tickets
		from 
			data_events e 
			inner join data_venues v on e.VenueID = v.VenueID
			inner join data_event_categories ec on e.EventID = ec.EventID
		where
			e.Status = 3
			and e.EventID = '$EventID'
		";
	$result = mysql_query($sql, $connection);
	$row = mysql_fetch_array($result);
	
	$Namespace = $row['Namespace'];
	$EventID = $row['EventID'];
	$MarketID = $row['MarketID'];
	$VenueID = $row['VenueID'];
	$Title = $row['Title'];
	$Description = $row['Description'];
	$Free = $row['Free'];
	$Price = $row['Price'];
	$Tickets = $row['Tickets'];
	
	$StartTime = strtotime($row["StartTime"]);
	$StopTime = strtotime($row["StopTime"]);

	$Created = new DateTime($row["Created"]);
	
	$EventUrl = cleanURL($row["SourceURL"]);
	$VenueUrl = cleanURL($row["VenueSourceUrl"]);
	
	$ShareUrl = "http://tixxfixx.com" .$EventUrl;
	
	
	$VenueName = $row['VenueName'];
	$Address = $row['Address'];
	$City = $row['City'];
	$Region = $row['Region'];
	$PostalCode = $row['PostalCode'];
	$Country = $row['Country'];
	$Latitude = $row['Latitude'];
	$Longitude = $row['Longitude'];
	$EditEvent = 1;
}

if ($_SESSION['contributor'] != 1)
{
	header("Location: /");	
}


function cleanURL($url)
{
	$url = str_replace("http://eventful.com", "", $url);
	$tempURL = explode("?", $url, -1);
	$url = $tempURL[0];
	return $url;
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<HTML xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-gb" lang="en-gb" >
<head>

    <title>TixxFixx.com</title>
    <meta name="keywords" content="<?php echo $_SESSION['location'] ?>,  events,  concerts,  tickets,  concert tickets, buy  tickets, sell  tickets, trade  tickets">
    <meta name="description" content="TixxFixx  - Your Ticket Solution- Your place to buy, sell, trade, consign or upgrade your event or concert tickets.">



   	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/head.php");  ?>


    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


    <link rel="stylesheet" href="/include/css/jquery.timepicker.css" type="text/css">
    <script type="text/javascript" src="/include/js/jquery.timepicker.js"></script>


    <link href="/include/css/select2.css" rel="stylesheet"/>
    <script src="/include/js/select2.min.js"></script>


    <script>
	    $(document).ready(function() {

            $("#StartDate").datepicker();
            $("#StartTime").timepicker({ 'scrollDefaultNow': true });

            $("#StopDate").datepicker();
            $("#StopTime").timepicker({ 'scrollDefaultNow': true });

			$("#select-venue").select2({
				placeholder: "Select a Venue",
				 allowClear: true
			});
			$("#select-performer").select2({
				placeholder: "Select a Performer",
				 allowClear: true
			});
			$("#select-category").select2({
				placeholder: "Select a Category",
				 allowClear: true
			});
			
			$("#select-venue").select2("val", "<?php echo $VenueID ?>");
			$("#select-performer").select2("val", "<?php echo $PerformerID ?>");
			$("#select-category").select2("val", "<?php echo $Namespace ?>");
			
		});

		function checkForm()
		{
			if ($("#Title").val() == "")
			{
				alert("Please enter a TITLE")
				return false;
			}
			if ($("#StartTime").val() == "")
			{
				alert("Please enter a START TIME")
				return false;
			}
			
			if (!$('#add-venue').is(":checked") && $('#event-details-VenueID').val() == "")
			{
				alert('Please either select a VENUE or add a new one');
				return false;	
			}
			
			if ($('#add-venue').is(":checked"))
			{
				
				if ($("#Name").val() == "")
				{
					alert("Please enter a VENUE NAME")
					return false;
				}
				if ($("#Address").val() == "")
				{
					alert("Please enter a VENUE ADDRESS")
					return false;
				}
				if ($("#City").val() == "")
				{
					alert("Please enter a VENUE CITY")
					return false;
				}
				if ($("#Region").val() == "")
				{
					alert("Please enter a VENUE STATE")
					return false;
				}
				if ($("#Zip").val() == "")
				{
					alert("Please enter a VENUE ZIP CODE")
					return false;
				}
			}
			
			if ($('#add-performer').is(":checked"))
			{
				
				if ($("#PerformerName").val() == "")
				{
					alert("Please enter a PERFORMER NAME")
					return false;
				}
			}
			
			if (!$('#add-category').is(":checked") && $('#event-details-Namespace').val() == "")
			{
				alert('Please select a CATEGORY or create a new one for this event.');
				return false;	
			}
			
			if ($('#add-category').is(":checked"))
			{

				if ($("#Category").val() == "")
				{
					alert("Please enter a CATEGORY")
					return false;
				}
			}
			
			
			
			
			$('#AddEventForm').submit();
		}
		
		function checkboxFree()
		{
			if ($('#Free').is(":checked"))
			{
				$('#Price').val('This event is free to the public');
			}
			else
			{
				$('#Price').val('');
			}
		}

    </script>
    
    <script>
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
	
	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/header.php");  ?>

	<div id="container_page">
    
    	<div id="content_page">
    		
			<div id="social">
            	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/social.php");  ?>            	
	        </div>

    
    		<div id="logo"><a href="/" title="TixxFixx.com"><img src="/images/logo.png" width="206" height="121" /></a></div>
            
            <div id="contet_body">
            	
                
                <div id="section-selector">
                    <a href="<?php echo $_SESSION['location_url'] ?>/events" class="section-selector-item margin-right blue_1">Events<div style="font-size: 11px;">All the local events and tickets you need</div></a>
                    <div onclick="checkLogin('/sales.php');" class="section-selector-item margin-right blue_2">My Sales<div style="font-size: 11px;">View and manage all your tickets, sales and revenues</div></div>
                    <div onclick="checkLogin('/orders.php');" class="section-selector-item blue_3">My Orders<div style="font-size: 11px;">Review the status of tickets you have purchased</div></div>
                </div>
                          
                <div id="event-selector">
                    <a href="<?php echo $_SESSION['location_url'] ?>/events/music" class="event-selector-item margin-right grey">Concerts</a>
                    <a href="<?php echo $_SESSION['location_url'] ?>/events/sports" class="event-selector-item margin-right grey">Sports</a>
                    <a href="<?php echo $_SESSION['location_url'] ?>/events/support" class="event-selector-item margin-right grey">Health & Wellness</a>
                    <a href="<?php echo $_SESSION['location_url'] ?>/events/festivals_parades" class="event-selector-item margin-right grey">Festivals</a>
                    <a href="<?php echo $_SESSION['location_url'] ?>/events/family_fun_kids" class="event-selector-item margin-right grey">Family Fun</a>
                    <a href="<?php echo $_SESSION['location_url'] ?>/events/singles_social" class="event-selector-item margin-right grey">Nightlife</a>
                    <a href="<?php echo $_SESSION['location_url'] ?>/events/performing_arts" class="event-selector-item margin-right grey">Arts & Theatre</a>
                    <a href="<?php echo $_SESSION['location_url'] ?>/events/food" class="event-selector-item margin-right grey">Food & Wine</a>
                    <a href="<?php echo $_SESSION['location_url'] ?>/events/other" class="event-selector-item grey">Other</a>
                </div>
                <div id="section-header">

                    <?php include($_SERVER['DOCUMENT_ROOT']."/include/template/search.php");  ?>

                	<h1 id="section-title">Add Event</h1>
                    <h2 id="section-desc">This is the spot that you can add events to the TixxFixx System.</h2>
                </div>
                
            
                <div class="event-left-column">
	                <div class="event-title">Event Details</div>
  

                    <div id="event-details-form" class="column-content">
                    	    <form class="form-horizontal" id="AddEventForm" name="AddEventForm" method="post" action="/Classes/event.add.php">
                            <input type="hidden" id="event-details-EventID" name="event-details-EventID" value="<?php echo $EventID ?>" />
                            <input type="hidden" id="event-details-VenueID" name="event-details-VenueID" value="<?php echo $VenueID ?>" />
                            <input type="hidden" id="event-details-PerformerID" name="event-details-PerformerID" value="<?php echo $PerformerID ?>" />
                            <input type="hidden" id="event-details-Namespace" name="event-details-Namespace" value="<?php echo $Namespace ?>" />
                            <div class="control-group">
                                <label class="control-label" for="Title">Title</label>
                                <div class="controls">
                                	<input type="text" id="Title" name="Title" value="<?php echo $Title ?>" placeholder="Event Title" required>
                                </div>
                            </div>
                            
                            <div class="control-group">
                            	<label class="control-label" for="Description">Description</label>
	                            <div class="controls">
		                            <textarea rows="3" id="Description" name="Description" name="Description"><?php echo $Description ?></textarea>
	                            </div>
                            </div>
                            
                            <div class="control-group">
                            	<label class="control-label" for="Price">Door Price</label>
	                            <div class="controls">
                                	<input type="text" id="Price" value="<?php echo $Price ?>" placeholder="Price" name="Price">
                                    <span class="help-block">
                                    <label class="checkbox">
	                                    <input type="checkbox" id="Free" name="Free" value="True" onclick="checkboxFree();"> This is a Free Event
                                    </label>
                                    </span>
	                            </div>
                            </div>
                            
                            <div class="control-group">
                            
                            	<label class="control-label" for="StartTime">Event Date</label>
                                <div class="controls">
                                    <input size="16" type="text" id="StartDate" name="StartDate" value="<?php echo date ("m/d/Y", $StartTime) ?>" style="width: 100px;">&nbsp;&nbsp;
                                </div>
                            </div>
                            
                            <div class="control-group">
                            
                            	<label class="control-label" for="StopTime">Event Time</label>
                                <div class="controls">
                                    <input type="text" id="StartTime" name="StartTime" value="<?php echo date ("H:ia", $StartTime) ?>" class="time" style="width: 100px;"> to
                                    <input type="text" id="StopTime" name="StopTime" value="<?php echo date ("H:ia", $StopTime) ?>" class="time" style="width: 100px;">
                                </div>
                            </div>
                            
                            <div id="new-venue" style="display:none;">
                            	
                                <hr />
                                
                                <div class="control-group">
                                    <label class="control-label" for="Name">Venue Name</label>
                                    <div class="controls">
                                        <input type="text" id="Name" name="Name" placeholder="Venue Name" value="<?php echo $VenueName ?>" required>
                                    </div>
                                </div>
                            
                                <div class="control-group">
                                    <label class="control-label" for="Address">Address</label>
                                    <div class="controls">
                                        <input type="text" id="Address" name="Address" placeholder="Address" value="<?php echo $Address ?>" required>
                                    </div>
                                </div>
                            
                                <div class="control-group">
                                    <label class="control-label" for="City">City</label>
                                    <div class="controls">
                                        <input type="text" id="City" name="City" placeholder="City" value="<?php echo $City ?>" required>
                                    </div>
                                </div>
                            
                                <div class="control-group">
                                    <label class="control-label" for="Region">State</label>
                                    <div class="controls">
                                        <input type="text" id="Region" name="Region" placeholder="State" value="<?php echo $Region ?>" required>
                                    </div>
                                </div>
                            
                                <div class="control-group">
                                    <label class="control-label" for="Zip">Zip Code</label>
                                    <div class="controls">
                                        <input type="text" id="Zip" name="Zip" placeholder="Zip" value="<?php echo $PostalCode ?>" required>
                                    </div>
                                </div>
                            
                            
                            </div>
                            
                            <div id="new-performer" style="display:none;">
                            	
                                <hr />
                            
                                <div class="control-group">
                                    <label class="control-label" for="PerformerName">Performer Name</label>
                                    <div class="controls">
                                        <input type="text" id="PerformerName" name="PerformerName" placeholder="Performer Name" value="<?php echo $PerformerName ?>" required>
                                    </div>
                                </div>
                            
                                <div class="control-group">
                                    <label class="control-label" for="Bio">Short Bio</label>
                                    <div class="controls">
		                            <textarea rows="3" id="Bio" name="Bio" required><?php echo $Bio ?></textarea>
                                    </div>
                                </div>
                            
                            </div>
                            
                            <div id="new-category" style="display:none;">
                            	
                                <hr />
                            
                                <div class="control-group">
                                    <label class="control-label" for="Category">Category</label>
                                    <div class="controls">
                                        <input type="text" id="Category" name="Category" placeholder="Category" value="<?php echo $Namespace ?>" required>
                                    </div>
                                </div>
                            </div>
                            	
                            <hr />
                            
                            <div class="control-group">
    	                        <div class="controls">
                                    <button type="button" class="btn" onclick="checkForm();">Save Event</button>
                    	        </div>
                            </div>
                            </form>
                    </div>
                    
                </div>
				
            
                <div class="event-right-column" id="">       
                    
                    <div class="event-liked-title">Event Venue</div>
                           
                    <div id="event-share" style="padding: 10px; background: #fff;">
                    
                    	
                    	    <form class="form-horizontal">
                            
                            <div class="control-group">
                                <select id="select-venue" style="width: 235px;" onchange="$('#event-details-VenueID').val(this.value);$('#add-venue').removeAttr('checked');$('#new-venue').hide();">
                                    <option value=""></option>
									<?php 
                        
                                    $sql = "select VenueID, Name from data_venues order by Name";
                                    $results = mysql_query($sql, $connection);
                                    while($row = mysql_fetch_array($results, MYSQL_ASSOC)) {
            
                                        $VenueID = $row["VenueID"];
                                        $Name = $row["Name"];
                                    ?>
                                        <option value="<?php echo $VenueID ?>"><?php echo $Name ?></option>
                                    <?php
                                    }
                                    ?>  
                                </select>
                                
                                <script>
									var VenueID = "<?php echo $VenueID ?>";
									$("#select-venue").val(VenueID);
								</script>
                                <?php if ($EditEvent == 0) { ?>
                                    <span class="help-block" style="padding-left: 10px;">
                                    <label class="checkbox">
                                        <input type="checkbox" id="add-venue" value="True" onclick="$('#select-venue').select2('val', '');$('#event-details-VenueID').val('');$('#new-venue').show();"> Add a New Venue
                                    </label>
                                    </span>
                                <?php } else { ?>
                                    <span class="help-block" style="padding-left: 10px;">
                                    <label class="checkbox">
                                        <input type="checkbox" id="add-venue" value="True" onclick="$('#new-venue').show();"> Edit This Venue
                                    </label>
                                    </span>
                                <?php } ?>
                            </div>
                            </form>
                    
                    </div>         
                    
                	<br style="clear:both;" />
                
                    <div class="event-liked-title">Performer</div>
                           
                    <div id="event-share" style="padding: 10px; background: #fff;">
                    
                    	
                    	    <form class="form-horizontal">
                            
                            <div class="control-group">
                                <select id="select-performer" style="width: 235px;" onchange="$('#event-details-PerformerID').val(this.value);$('#add-performer').removeAttr('checked');$('#new-performer').hide();">
                                    <option value=""></option>
									<?php 
                        
                                    $sql = "select PerformerID, Name from data_performers order by Name";
                                    $results = mysql_query($sql, $connection);
                                    while($row = mysql_fetch_array($results, MYSQL_ASSOC)) {
            
                                        $PerformerID = $row["PerformerID"];
                                        $Name = $row["Name"];
                                    ?>
                                        <option value="<?php echo $PerformerID ?>"><?php echo $Name ?></option>
                                    <?php
                                    }
                                    ?>  
                                </select>
                                <?php if ($EditEvent == 0 && $PerformerID != "") { ?>
                                    <span class="help-block" style="padding-left: 10px;">
                                    <label class="checkbox">
                                        <input type="checkbox" id="add-performer" value="True" onclick="$('#select-performer').select2('val', '');$('#event-details-PerformerID').val('');$('#new-performer').show();"> Add a New Performer
                                    </label>
                                    </span>
                                <?php } else { ?>
                                    <span class="help-block" style="padding-left: 10px;">
                                    <label class="checkbox">
                                        <input type="checkbox" id="add-performer" value="True" onclick="$('#new-performer').show();"> Edit Performer Performer
                                    </label>
                                    </span>
                                <?php } ?>
                            </div>
                            </form>
                    
                    </div>      
                    
                	<br style="clear:both;" />
                
                    <div class="event-liked-title">Category</div>
                           
                    <div id="event-share" style="padding: 10px; background: #fff;">
                    
                    	
                    	    <form class="form-horizontal">
                            
                            <div class="control-group">
                                <select id="select-category" style="width: 235px;" onchange="$('#event-details-Namespace').val(this.value);$('#add-category').removeAttr('checked');$('#new-category').hide();">
                                    <option value=""></option>
									<?php 
                        
                                    $sql = "select Namespace, Description from data_categories order by Description";
                                    $results = mysql_query($sql, $connection);
                                    while($row = mysql_fetch_array($results, MYSQL_ASSOC)) {
            
                                        $Namespace = $row["Namespace"];
                                        $Description = $row["Description"];
                                    ?>
                                        <option value="<?php echo $Namespace ?>"><?php echo $Description ?></option>
                                    <?php
                                    }
                                    ?>  
                                </select>
                                <span class="help-block" style="padding-left: 10px;">
                                <label class="checkbox">
                                    <input type="checkbox" id="add-category" value="True" onclick="$('#select-category').select2('val', '');$('#event-details-Namespace').val('');$('#new-category').show();"> Add a New Category
                                </label>
                                </span>
                            </div>
                            </form>
                    
                    </div>     
                     
                </div>
                <br style="clear:both;" />
                <br style="clear:both;" />
                                
            </div>
            
		</div>   
    
   		<div id="footer" style="margin: -198px 0 0; padding: 358px 0 0;"><?php include($_SERVER['DOCUMENT_ROOT']."/include/template/footer.php");  ?></div>	
    </div>
    
    
</body>
</html>


<?php
include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  

//Always place this code at the top of the Page
session_start();


function cleanURL($url)
{
	if (strrpos($url, "eventful"))
	{
		$url = str_replace("http://eventful.com", "", $url);
		$tempURL = explode("?", $url, -1);
		$url = $tempURL[0];
		return $url;
	}
	else
	{
		return $url;
	}
}


?>
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
                	<h1 id="section-title"><?php echo $CategoryDescription ?></h1>
                    <h2 id="section-desc">Your place to buy, sell, trade, consign or upgrade your event or concert tickets.</h2>
                </div>
                
                
                <div id="events-list">
                    
                    <div class="event-right-column">
                    
                        <div id="location-selector">
                            Location
                            <div id="location">
                            	<form action="/Classes/user.location.search.php" method="post" class="navbar-form">
                                    <div class="input-append">
                                    	<input type="text" id="location-box" name="location" value="<?php echo $_SESSION['location'] ?>" style="width: 212px;">
                                    	<div class="btn-group">
	                                        <button class="btn dropdown-toggle" data-toggle="dropdown" style="height:30px;">
	                                        <span class="caret" style="margin-top: 2px;"></span>
    	                                    </button>
        	                                <ul class="dropdown-menu">
		                                        <li><a href="/boise/">Boise</a></li>
	                                        </ul>
                                    	</div>
                                    </div>
                                </form>
                            </div>
                            
                        </div>
                        
                        <div style="display: ;">
                            <div class="event-title">Browse by date</div>
                   
                            <div id="event-dates">
                                <ul class="columnar columns-3">
                                    <li style="width: 125px;">
                                        <div><a style="<?php echo $BoldFuture ?>" data-ga-label="<?php echo $_SESSION['location'] ?> Events for All Dates" title="All <?php echo $_SESSION['location'] ?> events" href="<?php echo $_SESSION['location_url'] ?>/events/<?php echo $_SESSION['category'] ?>/">All dates</a></div>
                                        <div><a style="<?php echo $BoldToday ?>" data-ga-label="<?php echo $_SESSION['location'] ?> Events Listed for Today" title="<?php echo $_SESSION['location'] ?> events today" href="<?php echo $_SESSION['location_url'] ?>/events/<?php echo $_SESSION['category'] ?>/today">Today</a></div>
                                        <div><a style="<?php echo $BoldTomorrow ?>" data-ga-label="<?php echo $_SESSION['location'] ?> Events Listed for Tomorrow" title="<?php echo $_SESSION['location'] ?> events tomorrow" href="<?php echo $_SESSION['location_url'] ?>/events/<?php echo $_SESSION['category'] ?>/tomorrow">Tomorrow</a></div>
                                    </li>
                                    <li>                                    
                                        <div><a style="<?php echo $BoldThisWeek ?>" data-ga-label="This weeks <?php echo $_SESSION['location'] ?> Events" title="<?php echo $_SESSION['location'] ?> events this week" href="<?php echo $_SESSION['location_url'] ?>/events/<?php echo $_SESSION['category'] ?>/this-week">This week</a></div>                                    
                                        <div><a style="<?php echo $BoldNextWeek ?>" data-ga-label="Next weeks <?php echo $_SESSION['location'] ?> Events" title="<?php echo $_SESSION['location'] ?> events next weekend" href="<?php echo $_SESSION['location_url'] ?>/events/<?php echo $_SESSION['category'] ?>/next-week">Next Week</a></div>
                                        <div><a style="<?php echo $BoldThisMonth ?>" data-ga-label="This months <?php echo $_SESSION['location'] ?> Events" title="<?php echo $_SESSION['location'] ?> events this month" href="<?php echo $_SESSION['location_url'] ?>/events/<?php echo $_SESSION['category'] ?>/this-month">This month</a></div>
                                    </li>
                                </ul>
                            </div>
                    	</div>
                        
                        <br />
                
                
                        
                        <div class="event-title">Browse events</div>
                        
                            <div id="event-categories">
                                <ul class="columnar columns-3">  
                                  <li>
                                        <?php 
                            
                                        $sql = "select DISTINCT c.Namespace, c.Description from data_event_categories e inner join data_categories c on c.Namespace = e.Namespace";
                                        $results = mysql_query($sql, $connection);
                                        $cnt = 1;
                                        $cntAd = 0;
                                        while($row = mysql_fetch_array($results, MYSQL_ASSOC)) {
                
                                            $Namespace = $row["Namespace"];
                                            $Description = $row["Description"];
                                            
                                        ?>
                                            <div><a data-ga-label="<?php echo $Descriptio ?> Browse Link" title="<?php echo $_SESSION['location'] ?> <?php echo $Descriptio ?>" href="<?php echo $_SESSION['location_url'] ?>/events/<?php echo $Namespace ?>"><?php echo $Description ?></a></div>
                                            
                                        <?php
                                            $cnt ++;
                                        }
                                        ?>  
                                  </li>
                                </ul>
                            	<br style="clear:both" />
                            </div>
                            
                        <br />
                        
                            
                            
                            <div class="event-title">Share This Page</div>
                                   
                            <div id="event-share" style="padding: 0px; background: #fff;">
                                <div id="song-share" style="width: 300px;">
                                    <div class='shareaholic-canvas' data-shareaholic-widgets='share_buttons'></div>
                                 </div>
                            </div>     
                        
                    </div>    
                	
                        <?php 
						if ($search == "")
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
								";
								
								if ($ShowHomePage == 0)
								{
									$sql .= " and Namespace in ('$category') and Featured > 0";
								}
								else
								{
									$sql .= " and Featured = 2";	
								}
								
								$sql .= " and StartTime > NOW()
									
								order by 
									e.StartTime
								Limit 15";
								
						//echo $sql;
						$results = mysql_query($sql, $connection);
						$cnt = 1;
						$cntAd = 0;
						while($row = mysql_fetch_array($results, MYSQL_ASSOC)) {

							$StartTime = new DateTime($row["StartTime"]);
							$StopTime = new DateTime($row["StopTime"]);
							
							$EventUrl = cleanURL($row["SourceURL"]);
							$VenueUrl = cleanURL($row["VenueSourceUrl"]);
							$Tickets = $row["Tickets"];
							
						?>
                            <?php if ($cnt == 1) { ?>
                                    
                    			<div id="featured-list" style="width: 568px; float: left; margin-top: 32px;">
                                    <div class="event-liked-title" style="margin-bottom: -10px;">Featured Events</div>            
                                    <div id="featured">
							<?php 
								$closeFeatured = 1;
							} ?>                            
                            <div id="Featured-<?php echo $row["EventID"] ?>" class="event-item">
                                <div id="Featured-EventID-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["EventID"] ?></div>
                                <div id="Featured-VenueID-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["VenueID"] ?></div>
                                <div id="Featured-EventTitle-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["Title"] ?></div>
                                <div id="Featured-EventURL-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $EventUrl ?></div>
                                <div id="Featured-StartTime-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $StartTime->format('m-d-Y h:i A') ?></div>
                                <div id="Featured-VenueName-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["VenueName"] ?></div>
                                
                                <div class="thumb"><a href="<?php echo $EventUrl ?>"><img src="/Classes/images.cache.php?id=<?php echo $row["EventID"] ?>"  width="116" /></a></div>
                            
                                <div class="info">
                                    
                                    <div class="info-box">
                                        <h2><a href="<?php echo $EventUrl ?>"><?php echo $row["Title"] ?></a></h2>
                                        
                                        <h3><?php echo $StartTime->format('m-d-Y h:i A') ?><br /><?php echo $row["VenueName"] ?> - <?php echo $row["City"] ?>, <?php echo $row["Region"] ?></h3>
                                        
                                        <h3>Category: <?php echo $row["Namespace"] ?></h3>
                                    </div>
                                    
                                    <div class="small" style="margin: 10px 0 0; display: none;">Source: <?php echo $Source ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Price: <?php echo $Price ?></div>
                                    
                                </div>
                                
                                <div class="controls">
                                    
                                    <li class="no-border"><img src="/images/icon_more.png" height="10" /><a href="<?php echo $EventUrl ?>">More Info</a></li>
                                    <?php if ($_SESSION['ShowTickets'] == 1) { ?>
                                    	<?php if ($Tickets > 0) { ?>
	                                        <li><img src="/images/icon_cart.png" height="10" /><a href="<?php echo $EventUrl ?>">Buy tickets</a></li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($_SESSION['contributor'] == 1) { ?>
                                        <li onclick="showAddTickets('<?php echo $row["EventID"] ?>');"><img src="/images/icon_ticket.png" height="10" />Sell tickets</li>
                                        <li onclick="unfeatureEvent('<?php echo $row["EventID"] ?>', 'event');"><img src="/images/star_on.png" height="10" />Unfeature</li>
                                        <li onclick="changeImage('<?php echo $row["EventID"] ?>', 'event');" style="display: none;"><img src="/images/icon_settings.png" height="10" />Update Image</li>
                                    <?php } ?>
                                    
                                </div>
                            
                            </div>
                            
						<?php
							$cnt ++;
						}
						?>   
                        
					<?php if ($cnt > 1) { ?>
                            </div>
    
                        </div>
                    <?php } 
						}
					?>
                    <div class="event-liked-title" style="margin-top: 30px; margin-bottom: -10px; width: 558px; float: left;">
                        <?php if ($CategoryDescription != "TixxFixx.com") { ?>
                        	<a href="/">All Events</a> : <a href="/boise/events/<?php echo $category ?>"><?php echo $CategoryDescription ?></a>
                        <?php } else { ?>
                        	<a href="/">All Events</a>
                        <?php } ?>
                        
                        <?php if ($date != "Future") { ?>
                        	: <?php echo $date ?>
                        <?php } ?>
                    
                    </div>
                    <div id="events">
                                                
						<?php 
						
						if ($search == "")
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
									and Namespace in ('$category')";
							if ($BetweenStartDate == "")
							{
								$sql .=	" and StartTime > NOW()";
							}
							else
							{
								$sql .=	" and StartTime BETWEEN '".$BetweenStartDate."' AND '".$BetweenEndDate."'";	
							}
							$sql .=	" order by 
									e.StartTime
								Limit 50
								";
						}
						else
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
									and StartTime > NOW()
									and (Title LIKE '%" . $search . "%'
									   OR v.Name LIKE '%" . $search . "%')
								order by 
									e.StartTime
								Limit 50
								";
						}
						echo '<div style="display: none" id="sql">'.$sql.'</div>';
						$results = mysql_query($sql, $connection);
						$cnt = 1;
						$cntAd = 0;
						while($row = mysql_fetch_array($results, MYSQL_ASSOC)) {

							$StartTime = new DateTime($row["StartTime"]);
							$StopTime = new DateTime($row["StopTime"]);
							
							$EventUrl = cleanURL($row["SourceURL"]);
							$VenueUrl = cleanURL($row["VenueSourceUrl"]);
							$Tickets = $row["Tickets"];							
							$Featured = $row["Featured"];
						?>
                            
                            <div id="Event-<?php echo $row["EventID"] ?>" class="event-item">
                                <div id="EventID-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["EventID"] ?></div>
                                <div id="VenueID-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["VenueID"] ?></div>
                                <div id="EventTitle-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["Title"] ?></div>
                                <div id="EventURL-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $EventUrl ?></div>
                                <div id="EventDesc-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["Description"] ?></div>
                                <div id="StartDateFormated-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $StartTime->format('m-d-Y h:i A') ?></div>
                                <div id="StartTimeFormated-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $StopTime->format('m-d-Y h:i A') ?></div>
                                <div id="StartTime-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["StartTime"] ?></div>
                                <div id="StopTime-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["StopTime"] ?></div>
                                <div id="Price-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["Price"] ?></div>
                                <div id="Source-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["Source"] ?></div>
                                <div id="VenueName-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["VenueName"] ?></div>
                                <div id="VenueURL-<?php echo $row["EventID"] ?>" class="hidden">%VenueURL%</div>
                                <div id="Address-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["Address"] ?></div>
                                <div id="City-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["City"] ?></div>
                                <div id="State-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["Region"] ?></div>
                                <div id="PostalCode-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["PostalCode"] ?></div>
                                <div id="Longitude-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["Longitude"] ?></div>
                                <div id="Latitude-<?php echo $row["EventID"] ?>" class="hidden"><?php echo $row["Longitude"] ?></div>
                                
                                <div class="position">
                                    <?php echo $cnt ?>
                                </div>
                                <div class="info">
                                    
                                    
                                    
                                    <div class="info-box">
                                        <h2><a href="<?php echo $EventUrl ?>"><?php echo $row["Title"] ?></a><?php if ($_SESSION['contributor'] == 1) { ?>&nbsp;&nbsp;<small class="link" onclick="deleteEvent('<?php echo $row["EventID"] ?>')">remove</small><?php } ?></h2>
                                        
                                        <h3><?php echo $StartTime->format('m-d-Y h:i A') ?><br /><?php echo $row["VenueName"] ?> - <?php echo $row["City"] ?>, <?php echo $row["Region"] ?></h3>
                                        
                                        
                                        <h3>Category: <?php echo $row["Namespace"] ?></h3>
                                    </div>
                                    
                                    <div class="small" style="margin: 10px 0 0; display: none;">Source: <?php echo $row["Source"] ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Price: <?php echo $row["Price"] ?></div>
                                    
                                </div>
                                
                                <div class="controls">
                                    
                                    <li class="no-border"><img src="/images/icon_more.png" height="10" /><a href="<?php echo $EventUrl ?>">More Info</a></li>
                                    <?php if ($_SESSION['ShowTickets'] == 1) { ?>
                                    	<?php if ($Tickets > 0) { ?>
	                                        <li><img src="/images/icon_cart.png" height="10" /><a href="<?php echo $EventUrl ?>">Buy tickets</a></li>
                                        <?php } ?>
                                    <?php } ?>
                                    <?php if ($_SESSION['contributor'] == 1) { ?>
                                        <li onclick="showAddTickets('<?php echo $row["EventID"] ?>');"><img src="/images/icon_ticket.png" height="10" />Sell tickets</li>
                                        <?php if ($Featured == 1) { ?>
	                                        <li onclick="unfeatureEvent('<?php echo $row["EventID"] ?>', 'event');"><img src="/images/star_on.png" height="10" />Unfeature</li>
                                        <?php } else { ?>
	                                        <li onclick="featureEvent('<?php echo $row["EventID"] ?>', 'event');"><img src="/images/star_off.png" height="10" />Feature</li>
                                        <?php } ?>
                                        <li onclick="changeImage('<?php echo $row["EventID"] ?>', 'event');" style="display: none;"><img src="/images/icon_settings.png" height="10" />Update Image</li>
                                    <?php } ?>
                                    
                                </div>
                            
                            </div>
                            
						<?php
							$cnt ++;
						}
						if ($cnt < 2)
						{
						?>     
						<div class="column-content" style="margin-top:10px; text-align: center;">
                        	<?php if ($search == "") { ?>
	                        	No events currently listed for this category.
                            <?php } else { ?>
                            	No results found for: <strong><?php echo $search ?></strong>
                            <?php } ?>
                        </div>            
                        <?php } ?>
                    </div>   
                    
				</div>       
                        
            
                
                <br style="clear:both;" />
                
                
                

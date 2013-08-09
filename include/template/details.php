<?php
include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  

//Always place this code at the top of the Page
session_start();


function cleanURL($url)
{
	$url = str_replace("http://eventful.com", "", $url);
	$tempURL = explode("?", $url, -1);
	$url = $tempURL[0];
	return $url;
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
                
                
                
                                
						<?php 
						
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
						
						$StartTime = new DateTime($row["StartTime"]);
						$StopTime = new DateTime($row["StopTime"]);
						$Created = new DateTime($row["Created"]);
						
						
						$Source = $row["Source"];
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
							
						?>
                            
                <div id="event-header">                	
                	<table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                    	<td valign="top" id="Event-Title-Img"><img src="/Classes/images.cache.php?id=<?php echo $EventID ?>" width="116" height="116" class="event_image" style="padding: 0 0 0 10px;"></td>
                        <td width="100%" valign="top" style="padding: 0px 0px 0px 20px;">                        
		                	<h1 id="Event-Title-EventName"><?php echo $Title ?></h1>
		                	<h2 id="Event-Title-StartTime"><?php echo $StartTime->format('m-d-Y h:i A') ?></h2>
		                	<h3 id="Event-Title-VenueName"><?php echo $VenueName ?></h3>
                            
                            <br />
                            <br />
                        </td>
                        <td nowrap="nowrap" valign="top">      
                        </td>
					</tr>
                    </table>
                </div>
                
                <div id="event">

                        <div class="event-left-column">

                            <div class="event-title">Event Details</div>
                                
                            <div id="event-tickets" class="column-content">
                                <div id="event-details">
                                	
                                    <strong id="Event-Details-Title"><?php echo $Title ?></strong>
                                	
                                    <p id="Event-Details-Text"><?php echo $Description ?></p>
                                    
                                    <?php 
									if ($Free == "1") 
									{ 
									    if ($Price != "") 
                                        { 
	                                    	echo '<p><span id="Event-Details-Price">'.$Price.'</span></p>';
                                    	} 
										else
										{
                                        	echo '<p><span id="Event-Details-Price">This event is free to the public</span></p>';
										}
                                    } 
									else 
									{
									    if ($Price != "") 
                                        { 
                                        	echo '<p>Door Price: <span id="Event-Details-Price">'.$Price.'</span></p>';
                                    	} 
									}
									?>
                                	
                                    <p><small>Source: <?php echo $Source ?></small></p>
                                    
                                	<hr />
                                    

                                    
                                    <p id="Event-Details-Links"></p>
                                
                                </div>
                            </div>
                            
                            <br />
                            
                            
                            <?php 
							if ($_SESSION['ShowTickets'] == 1) 
							{
								if ($Tickets > 0)
								{
							?>
                            	
                            <div class="event-title" style="padding-right:10px;">Tickets <span class="pull-right link" onclick="getCart();">View Cart</span></div>
                        	
                            <div id="event-tickets" class="column-content">
                                
                                <div id="event-tickets-list">
                                
                                <?php	
                                $sql = sprintf("select 
                                            t.id,
                                            t.EventID,
                                            t.UserID,
                                            t.TicketType,
                                            t.TicketDesc,
                                            t.Section,
                                            t.Row,
                                            t.Seats,
                                            (Qty - Sold - IFNULL((select sum(Qty) from cart_items where TicketID = t.id and TIMESTAMPDIFF(MINUTE, AddedOn, now()) < 20),0)) as Qty,
                                            t.Price,
                                            t.Splits,
                                            t.AdditionalInfo,
                                            t.eTixx,
                                            t.FedEx,
                                            t.WillCall,
                                            t.Contact,
                                            t.AddedOn,        
                                            t.AddedBy,
                                            u.username,
                                            u.fullname,
                                            t.UpdatedOn,
                                            t.UpdatedBy,
                                            t.Status
                                        from 
                                            tickets t
                                            inner join users u on t.AddedBy = u.id
                                        where 
                                            t.EventID = '%s'
											and t.Status = 1
											", 
                                            mysql_real_escape_string($EventID));
                                $rs = mysql_query($sql, $connection);
                                
                                $results = mysql_query($sql, $connection);
                                $cnt = 1;
                                $cntAd = 0;
                                while($row = mysql_fetch_array($results, MYSQL_ASSOC)) {
    							
									$TicketID = $row['id'];
									$TicketType = $row['TicketType'];
									$TicketDesc = $row['TicketDesc'];
									$Section = $row['Section'];
									$Row = $row['Row'];
									$Seats = $row['Seats'];
									$Qty = $row['Qty'];
									$Price = $row['Price'];
									$Splits = $row['Splits'];
									$AdditionalInfo = $row['AdditionalInfo'];
									$AddedOn = $row['AddedOn'];
									$username = $row['username'];
									$fullname = $row['fullname'];
                                  
									if ($Qty == "0")
									{
										$ShowAddToCart = "display: none;";	
										$ShowSoldOut = "";	
									}
									else
									{
										$ShowAddToCart = "";	
										$ShowSoldOut = "display: none;";	
									}
									
									if ($Splits == "true")
									{
										if ($Qty > 1)
										{	
											$qtyList = '<select name="Ticket-Qty-Select-' .$TicketID. '" id="Ticket-Qty-Select-' .$TicketID. '" Enabled="true">';
											for ($i = 1; $i <= $Qty; $i++) {
												$qtyList .= '<option value="' . $i . '" onclick="selectThis(' .$TicketID. ', ' . ($i - 1) . ');">' . $i . '</option>';
											}
											$qtyList .= "</select>";
											
											$Qty = $qtyList;
											
										}
										else
										{
											//Qty = '<input name="Ticket-Qty-Select-' .$TicketID. '" id="Ticket-Qty-Select-' .$TicketID. '" value="' + Qty + '" class="span2" id="prependedInput" type="text">';
										}
									}
									else
									{
										//Qty = '<input name="Ticket-Qty-Select-' .$TicketID. '" id="Ticket-Qty-Select-' .$TicketID. '" value="' + Qty + '" class="span2" id="prependedInput" type="text">';
									}
									
									if ($Row == "null" || $Row == "")
									{
										$ShowRowSeat = "display: none;";
									}
									else
									{
										$ShowRowSeat = "";	
									}
                                
                                ?>
                                
                                <div id="Ticket-<?php echo $TicketID ?>" class="ticket-item">
                                    <div id="Ticket-TicketID-<?php echo $TicketID ?>" class="hidden"><?php echo $TicketID ?></div>
                                    <div id="Ticket-EventID-<?php echo $TicketID ?>" class="hidden"><?php echo $row["EventID"] ?></div>
                                    <div id="Ticket-TicketType-<?php echo $TicketID ?>" class="hidden"><?php echo $TicketType ?></div>
                                    <div id="Ticket-TicketDesc-<?php echo $TicketID ?>" class="hidden"><?php echo $TicketDesc ?></div>
                                    <div id="Ticket-Section-<?php echo $TicketID ?>" class="hidden"><?php echo $Section ?></div>
                                    <div id="Ticket-Row-<?php echo $TicketID ?>" class="hidden"><?php echo $Row ?></div>
                                    <div id="Ticket-Seats-<?php echo $TicketID ?>" class="hidden"><?php echo $Seats ?></div>
                                    <div id="Ticket-Qty-<?php echo $TicketID ?>" class="hidden"><?php echo $Qty ?></div>
                                    <div id="Ticket-Price-<?php echo $TicketID ?>" class="hidden"><?php echo $Price ?></div>
                                    <div id="Ticket-Splits-<?php echo $TicketID ?>" class="hidden"><?php echo $Splits ?></div>
                                    <div id="Ticket-AdditionalInfo-<?php echo $TicketID ?>" class="hidden"><?php echo $AdditionalInfo ?></div>
                                    <div id="Ticket-AddedOn-<?php echo $TicketID ?>" class="hidden"><?php echo $AddedOn ?></div>
                                    
                                    <div class="position">
                                        <?php echo $cnt ?>
                                    </div>
                                    <div class="info">
                                        
                                        <div class="info-box">
                                            
                                            <div style="width: 175px; float: left;">
                                                <b><?php echo $TicketDesc ?></b>
                                            </div>
                                            <div style="width: 100px; float: left;">
                                                 <b>Qty: </b><?php echo $Qty ?>
                                            </div>
                                            <div style="width: 90px; float: left;">
                                                <b>Price: </b>$<?php echo $Price ?>
                                            </div>
                                            <div class="controls">
                                                <li class="no-border" onclick="addTicketCart(<?php echo $TicketID ?>);" style="color: #BD1E2D; <?php echo $ShowAddToCart ?>"><img src="/images/icon_cart.png" height="10" />add to cart</li>
                                                <li class="no-border" style="color: #ooo; <?php echo $ShowSoldOut ?>"><img src="/images/icon_cart.png" height="10" />SOLD OUT</li>
                                            </div>
                                            
                                            
                                            <div style="clear: both"></div>
                                            
                                            <div style="float: left; <?php echo $ShowRowSeat ?>">
                                                <b>Row:</b> <?php echo $Row ?>&nbsp;&nbsp;&nbsp;&nbsp;<b>Seats:</b> <?php echo $Seats ?>&nbsp;&nbsp;&nbsp;&nbsp;
                                            </div>
                                            
                                            <div style="float: left; display: none;">
                                                <b>Seller:</b> <?php echo $username ?>
                                            </div>
                                            <div style="clear: both; display:none;">
                                                <?php echo $AdditionalInfo ?>
                                            </div>
                                        </div>
                                        
                                        
                                    </div>
                                    
                                
                                </div>
                                <div style="clear:both;"></div>
								<?php 
									$cnt++;
                                } 
                                ?>
								</div>
                        	</div>
                            
                            <br />
                        
                            <?php 
								}
							}
							?>
                            <div class="event-title">Who's Going</div>
                            
                            <div id="event-comments" class="column-content" style="min-height: 400px; padding: 0px;"></div>
                            
                            <script>
								$("#event-comments").html('<div class="fb-comments" data-href="<?php echo $ShareUrl ?>" data-num-posts="10" data-width="542"></div>');
							</script>
                        
                        </div>
                        
            
                        <div class="event-right-column" id="">       
                        	
                        	<div class="event-liked-title">Share This Page</div>
                                   
                            <div id="event-share" style="padding: 0px; background: #fff;">
                            	<div id="song-share" style="width: 300px;">
		                            <div class='shareaholic-canvas' data-shareaholic-widgets='share_buttons'></div>
                                 </div>
                            </div>     
                             
                        </div>
                        
                        <?php if ($_SESSION['contributor'] == 1) { ?>
                        
                        <div class="event-right-column" style="margin-top:20px;">       
                        	
                        	<div class="event-liked-title">Event Settings</div>
                                   
                            <div id="event-share" style="padding: 10px; background: #fff;">
                               	<div class="link" onclick="window.location='/event_set.php?ID=<?php echo $row["EventID"] ?>';"><img src="/images/icon_settings.png" height="12" />Edit Event Details</div>
                              	<div class="link" onclick="showAddTickets('<?php echo $row["EventID"] ?>');"><img src="/images/icon_ticket.png" height="12" />Sell tickets</div>
                              	<div class="link" onclick="featureEvent('<?php echo $row["EventID"] ?>', 'event');"><img src="/images/star_off.png" height="12" />Feature this event</div>
                            </div> 
                        </div>
            
                        <?php } ?>
                             
                </div>

                <br style="clear:both;" />
                
                
                

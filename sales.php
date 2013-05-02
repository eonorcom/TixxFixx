<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php

session_start();
$UserID = $_SESSION['id'];

if ($UserID == "")
{
	header("Location: /");	
}

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
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><?php

//Always place this code at the top of the Page
session_start();

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title>TixxFixx.com</title>
    <meta name="keywords" content="<?php echo $_SESSION['location'] ?>,  events,  concerts,  tickets,  concert tickets, buy  tickets, sell  tickets, trade  tickets">
    <meta name="description" content="TixxFixx  - Your Ticket Solution- Your place to buy, sell, trade, consign or upgrade your event or concert tickets.">

   	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/head.php");  ?>    
    <script>
		$.cookie("show", 0);
	</script>
     <script>
		(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=435317736521241";
		fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
		
		function gotoOrder(id)
		{
			window.location = '/order.php?ID=' + id;
		}
		
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
    
            <?php include($_SERVER['DOCUMENT_ROOT']."/include/template/search.php");  ?>
            
    
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
                        <h1 id="section-title">My Sales</h1>
                        <h2 id="section-desc">View and manage all your tickets, sales and revenues</h2>
                    </div>
                    
                    
                    
                    
                    <div id="checkout-info"  style="width: 400px; float: left;">
                        <div class="event-title">Orders</div>
                        <div id="content">
                        	<table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>Amount</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                        	<?php
								$sql = sprintf("select * from transactions where UserID = '%s' order by TransactionDate Desc",
										mysql_real_escape_string($UserID));
								$results = mysql_query($sql);
								
								
								// Balance available to withdraw from TixxFixx
								// Pending is waiting for approval to withdraw
								while($row = mysql_fetch_array($results)) {
									$TransactionId = $row['TransactionId'];
									$Amount = $row['Amount'];
									$TransactionDate = $row['TransactionDate'];
									$TransactionDate = new DateTime($TransactionDate);
								?>
                                	<tr style="cursor: pointer" onclick="gotoOrder('<?php echo $TransactionId ?>');">
                                    	<td><?php echo $TransactionId ?></td>
                                    	<td><?php echo $Amount ?></td>
                                    	<td><?php echo $TransactionDate->format('m/d/Y'); ?></td>
                                    </tr>
                                <?php
								}
							?>
                            </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div id="sales-balance"  style="width: 400px; float: right;">
                        <div class="event-title">Your Balance</div>
                        <div id="content" style="text-align:center;">
                        	Your current TixxFixx Balance is:
                        	<?php
								$sql = sprintf("select * from Balance where UserID = '%s'",
										mysql_real_escape_string($UserID));
								$results = mysql_query($sql);
								
								
								// Balance available to withdraw from TixxFixx
								// Pending is waiting for approval to withdraw
								while($row = mysql_fetch_array($results)) {
									$Balance = $row['Balance'];
									$PendingBalance = $row['PendingBalance'];
								}
								echo "<h1>".$Balance."</h1>";
							?>
                            Your pending balance is $<?php echo $PendingBalance ?>.
                            
                            <div style="text-align:left; font-size:10px; line-height: 10px; margin-top: 20px;">You will be able to withdraw your money from your TixxFixx account directly to your paypal account when it becomes available.</div>
                        </div>
                    </div>
                    
                    <br style="clear:both" />
                    <br style="clear:both" />
                    
                
                    <div class="event-title">Current Ticket Listings</div>
                    <div id="cart-info" style="background-color: #fff; padding: 20px; font-size: 12px;">
                        
                        <div id="checkout-tickets-list">
                        
                            <?php
                            $showTixx = 0;
                            $showFedEx = 0;
                            $showWillCall = 0;
                            $showContact = 0;
                            $showMuliple = 0;
                            $cnt = 1;
                            
                            $sql = sprintf("SELECT
												e.EventID,
												v.VenueID,
												t.id as TicketID,
												t.Qty,
												t.Sold,
												t.Price,
												t.TicketType,
												t.TicketDesc,
												t.Section,
												t.Row,
												t.Seats,
												t.AdditionalInfo,
												t.eTixx,
												t.FedEx,
												t.WillCall,
												t.Contact,
												t.AddedBy,
												e.Title,
												e.Description,
												e.SourceURL,
												e.StartTime,
												v.Name,
												v.Address,
												v.City,
												v.Region
											from 
												tickets t
												inner join data_events e on t.EventID = e.EventID
												inner join data_venues v on e.VenueID = v.VenueID
											where 
												t.UserID = '%s'
												and t.status = 1
											", 		
                            mysql_real_escape_string($UserID));
                            $results = mysql_query($sql);
                            
                            
                            while($row = mysql_fetch_array($results)) {
                                $EventID = $row['EventID'];
                                $VenueID = $row['VenueID'];
                                $TicketID = $row['TicketID'];
                                $Qty = $row['Qty'];
                                $Sold = $row['Sold'];
                                $Price = $row['Price'];
                                $SubTotal = $row['SubTotal'];
                                $TicketType = $row['TicketType'];
                                $TicketDesc = $row['TicketDesc'];
                                $Section = $row['Section'];
                                $Row = $row['Row'];
                                $Seats = $row['Seats'];
                                $AdditionalInfo = $row['AdditionalInfo'];
                                $eTixx = $row['eTixx'];
                                $FedEx = $row['FedEx'];
                                $WillCall = $row['WillCall'];
                                $Contact = $row['Contact'];
                                $AddedBy = $row['AddedBy'];
                                $username = $row['username'];
                                $fullname = $row['fullname'];
                                $EventTitle = $row['Title'];
                                $EventDesc = $row['Description'];
                                $SourceURL = $row['SourceURL'];
                                $StartTime = $row['StartTime'];
                                $VenueName = $row['Name'];
                                $Address = $row['Address'];
                                $City = $row['City'];
                                $State = $row['Region'];
                                
                                $StartDate = new DateTime($StartTime);
                                $TheDate = $StartDate->format('m/d/Y');
                                $TheTime = " at " . $StartDate->format('H:i:s');
                                if ($TheTime = "00:00:00")
                                {
                                    $TheTime = "";	
                                }
								
								$EventUrl = cleanURL($SourceURL);
								$GrossTotal = $Sold * $Price;
                            ?>
                            
                                <div id="checkout-template">
                                    <div id="Cart-%TicketID%" class="cart-item">
                                                                                
                                        <div style="position:relative; top: 10px; right: 10px; width: 15px; float: right;">
                                            <div class="no-border link" onclick="deleteTickets(<?php echo $TicketID ?>);" style="color: #BD1E2D;"><img src="/images/icon_delete.png" height="10" /></div>
                                        </div>

                                        <div class="position">
                                            <?php echo $cnt ?>
                                        </div>
                                        <div class="info" style="margin-top: -13px;">
                                            <div class="info-box">
                                                
                                                <div>
                                                <h2><a href="<?php echo $EventUrl ?>"><?php echo $EventTitle ?> @ <?php echo $VenueName ?></a></h2>
                                                <h3>
                                                    <?php echo $City ?>, <?php echo $State ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $TheDate ?> <?php echo $TheTime ?>
                                                    
                                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Delivery: 
                                                    
                                                    <?php
                                                        if ($eTixx == "true")
                                                        {
                                                            echo "eTixx";
                                                            $showTixx = 1;
                                                        }
                                                        
                                                        if ($FedEx == "true")
                                                        {
                                                            echo "FedEx Shipping";
                                                            $showFedEx = 1;
                                                            if ($showTixx == 1)
                                                            {
                                                                $showMuliple = 1;
                                                            }
                                                        }
                                                        
                                                        if ($WillCall == "true")
                                                        {
                                                            echo "Will Call";															
                                                            $showWillCall = 1;
                                                            if (($showTixx == 1) || ($showFedEx == 1))
                                                            {
                                                                $showMuliple = 1;
                                                            }
                                                        }
                                                        
                                                        if ($Contact == "true")
                                                        {
                                                            echo "Direct Contact";
                                                            $showContact = 1;
                                                            if (($showTixx == 1) || ($showFedEx == 1) || ($showWillCall == 1))
                                                            {
                                                                $showMuliple = 1;
                                                            }
                                                        }
                                                    
                                                    ?>
                                                
                                                </h3>
                                                </div>
                                                <div>
                                                    <div style="width: 306px; float: left; padding-right: 10px;">
                                                        <b><?php echo $TicketDesc ?></b>
                                                    </div>
                                                    <div style="width: 100px; float: left; padding-right: 10px;">
                                                        <b>Qty: </b><div style="float: right;"><?php echo $Qty ?></div>
                                                    </div>
                                                    <div style="width: 100px; float: left; padding-right: 10px;">
                                                        <b>Sold: </b> <div style="float: right;"><?php echo $Sold ?></div>
                                                    </div>
                                                    <div style="width: 100px; float: left; padding-right: 10px;">
                                                        <b>Price: </b> <div style="float: right;"><?php echo $Price ?></div>
                                                    </div>
                                                    <div style="width: 100px; float: left; padding-right: 10px;">
                                                        <b>Gross: </b> <div style="float: right;">$<?php echo $GrossTotal ?></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            <?php
								$cnt++;
                            }
                            ?>
                                
                        
                        
                        
                        </div>
                    </div>
                 
                <br style="clear: both;" />
                        
            </div>
            
		</div>   
    
   		<div id="footer" style="margin: -198px 0 0; padding: 358px 0 0;"><?php include($_SERVER['DOCUMENT_ROOT']."/include/template/footer.php");  ?></div>	
    </div>
    

</body>
</html>


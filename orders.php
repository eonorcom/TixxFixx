<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php

session_start();
$UserID = $_SESSION['id'];
if ($UserID == "")
{
	header("Location: /");	
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
                    <h1 id="section-title">My Orders</h1>
                    <h2 id="section-desc">Review the status of tickets you have purchased</h2>
                </div>
                
                
                
                
                <div id="order-list">
                    <div class="event-title">Order History</div>
                    <div id="content">
                        <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th style="text-align:center;">Amount</th>
                                <th style="text-align:center; display: none;">Seller Approved</th>
                                <th style="text-align:center; display: none;">Buyer Approved</th>
                                <th style="text-align:center;">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql = sprintf("select * from orders where UserID = '%s'",
                                    mysql_real_escape_string($UserID));
                            $results = mysql_query($sql);
                            
                            
                            // Balance available to withdraw from TixxFixx
                            // Pending is waiting for approval to withdraw
                            while($row = mysql_fetch_array($results)) {
                                $TransactionId = $row['TransactionId'];
                                $Amt = $row['Amt'];
                                $SellerApprove = $row['SellerApprove'];
                                $BuyerApprove = $row['BuyerApprove'];
                                $Amount = $row['Amount'];
                                $OrderTime = $row['OrderTime'];
                                $OrderTime = new DateTime($OrderTime);
                                $OrderItems = $row['OrderItems'];
								
								
                                
                            ?>
                                <tr style="cursor: pointer" onclick="gotoOrder('<?php echo $TransactionId ?>');">
                                    <td><?php echo $TransactionId ?></td>
                                    <td style="text-align:right;">$<?php echo $Amt ?></td>
                                    <td style="text-align:center; display: none;"><?php echo $SellerApprove ?></td>
                                    <td style="text-align:center; display: none;"><?php echo $BuyerApprove ?></td>
                                    <td style="text-align:center;"><?php echo $OrderTime->format('m/d/Y'); ?></td>
                                </tr>
                            <?php
                            }
                        ?>
                        </tbody>
                        </table>
                    </div>
                </div>
                        
            </div>
            
		</div>   
    
   		<div id="footer" style="margin: -198px 0 0; padding: 358px 0 0;"><?php include($_SERVER['DOCUMENT_ROOT']."/include/template/footer.php");  ?></div>	
    </div>
    

</body>
</html>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php

session_start();
	/*==================================================================
	 PayPal Express Checkout Call
	 ===================================================================
	*/
include($_SERVER['DOCUMENT_ROOT']."/Classes/paypal/paypalfunctions.php");


$OrderID = $_GET["ID"];
$Debug = $_GET["Debug"];
$ShowError = 0;
if ( $OrderID == "" )
{
	/*
	'------------------------------------
	' The paymentAmount is the total value of 
	' the shopping cart, that was set 
	' earlier in a session variable 
	' by the shopping cart page
	'------------------------------------
	*/
	
	$finalPaymentAmount =  $_SESSION["Payment_Amount"];
	
	/*
	'------------------------------------
	' Calls the DoExpressCheckoutPayment API call
	'
	' The ConfirmPayment function is defined in the file PayPalFunctions.jsp,
	' that is included at the top of this file.
	'-------------------------------------------------
	*/

	$resArray = ConfirmPayment ( $finalPaymentAmount );
	//print_r($resArray) . "<br><br>";
	$ack = strtoupper($resArray["ACK"]);
	if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
	{
		/*
		'********************************************************************************************************************
		'
		' THE PARTNER SHOULD SAVE THE KEY TRANSACTION RELATED INFORMATION LIKE 
		'                    transactionId & orderTime 
		'  IN THEIR OWN  DATABASE
		' AND THE REST OF THE INFORMATION CAN BE USED TO UNDERSTAND THE STATUS OF THE PAYMENT 
		'
		'********************************************************************************************************************
		*/

		$transactionId		= $resArray["PAYMENTINFO_0_TRANSACTIONID"]; // ' Unique transaction ID of the payment. Note:  If the PaymentAction of the request was Authorization or Order, this value is your AuthorizationID for use with the Authorization & Capture APIs. 
		$transactionType 	= $resArray["PAYMENTINFO_0_TRANSACTIONTYPE"]; //' The type of transaction Possible values: l  cart l  express-checkout 
		$paymentType		= $resArray["PAYMENTINFO_0_PAYMENTTYPE"];  //' Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant 
		$orderTime 			= $resArray["PAYMENTINFO_0_ORDERTIME"];  //' Time/date stamp of payment
		$amt				= $resArray["PAYMENTINFO_0_AMT"];  //' The final amount charged, including any shipping and taxes from your Merchant Profile.
		$currencyCode		= $resArray["PAYMENTINFO_0_CURRENCYCODE"];  //' A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD. 
		$feeAmt				= $resArray["PAYMENTINFO_0_FEEAMT"];  //' PayPal fee amount charged for the transaction
		//$settleAmt			= $resArray["SETTLEAMT"];  //' Amount deposited in your PayPal account after a currency conversion.
		$taxAmt				= $resArray["PAYMENTINFO_0_TAXAMT"];  //' Tax charged on the transaction.
		//$exchangeRate		= $resArray["EXCHANGERATE"];  //' Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer’s account.
		
		
		$_SESSION['TransactionId'] = $transactionId;
		
		/*
		' Status of the payment: 
				'Completed: The payment has been completed, and the funds have been added successfully to your account balance.
				'Pending: The payment is pending. See the PendingReason element for more information. 
		*/
		
		$paymentStatus	= $resArray["PAYMENTINFO_0_PAYMENTSTATUS"]; 

		/*
		'The reason the payment is pending:
		'  none: No pending reason 
		'  address: The payment is pending because your customer did not include a confirmed shipping address and your Payment Receiving Preferences is set such that you want to manually accept or deny each of these payments. To change your preference, go to the Preferences section of your Profile. 
		'  echeck: The payment is pending because it was made by an eCheck that has not yet cleared. 
		'  intl: The payment is pending because you hold a non-U.S. account and do not have a withdrawal mechanism. You must manually accept or deny this payment from your Account Overview. 		
		'  multi-currency: You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment. 
		'  verify: The payment is pending because you are not yet verified. You must verify your account before you can accept this payment. 
		'  other: The payment is pending for a reason other than those listed above. For more information, contact PayPal customer service. 
		*/
		
		$pendingReason	= $resArray["PAYMENTINFO_0_PENDINGREASON"];  

		/*
		'The reason for a reversal if TransactionType is reversal:
		'  none: No reason code 
		'  chargeback: A reversal has occurred on this transaction due to a chargeback by your customer. 
		'  guarantee: A reversal has occurred on this transaction due to your customer triggering a money-back guarantee. 
		'  buyer-complaint: A reversal has occurred on this transaction due to a complaint about the transaction from your customer. 
		'  refund: A reversal has occurred on this transaction because you have given the customer a refund. 
		'  other: A reversal has occurred on this transaction due to a reason not listed above. 
		*/
		
		
		
		$reasonCode		= $resArray["PAYMENTINFO_0_REASONCODE"]; 
		
		$UserID = $_SESSION['id'];
		$sql = sprintf("select * from user_info where UserID = '%s' and EndDate is null",
				mysql_real_escape_string($UserID));
		$results = mysql_query($sql);
		
		while($row = mysql_fetch_array($results)) {
			$UserInfoId = $row['id'];
			$FirstName = $row['FirstName'];
			$LastName = $row['LastName'];
			$Address1 = $row['Address1'];
			$Address2= $row['Address2'];
			$City = $row['City'];
			$State = $row['State'];
			$Zip = $row['Zip'];
			$Phone = $row['Phone'];
			$Email = $row['Email'];
		}
		
		$json = $_SESSION["OrderItems"];
		
		$insert = sprintf("INSERT INTO orders (UserID, UserInfoId, TransactionId, TransactionType, PaymentType, PayPalTime, Amt, CurrencyCode, FeeAmt, TaxAmt, PaymentStatus, PendingReason, ReasonCode, SellerApprove, BuyerApprove, OrderItems, resArray, OrderTime) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', NOW())",
			mysql_real_escape_string($UserID),
			mysql_real_escape_string($UserInfoId),
			mysql_real_escape_string($transactionId),
			mysql_real_escape_string($transactionType),
			mysql_real_escape_string($paymentType),
			mysql_real_escape_string($orderTime),
			mysql_real_escape_string($amt),
			mysql_real_escape_string($currencyCode),
			mysql_real_escape_string($feeAmt),
			mysql_real_escape_string($taxAmt),
			mysql_real_escape_string($paymentStatus),
			mysql_real_escape_string($pendingReason),
			mysql_real_escape_string($reasonCode),
			mysql_real_escape_string(0),
			mysql_real_escape_string(0),
			mysql_real_escape_string($json),
			mysql_real_escape_string(serialize($resArray)));
		//echo $insert . "<br><br>";
		mysql_query($insert);
		

		$JSON = json_decode($json,true);
		
		foreach ($JSON["items"] as $key => $value) {
			$CartID = $JSON["items"][$key]["CartID"];
			$TicketID = $JSON["items"][$key]["TicketID"];
			$Qty = $JSON["items"][$key]["Qty"];
			$Price = $JSON["items"][$key]["Price"];
			$SellerID = $JSON["items"][$key]["SellerID"];
			
			$TicketAmt = intval($Qty) * floatval($Price);
			
			$update = sprintf("Update tickets set Sold = Sold + %s where id = '%s'",
				mysql_real_escape_string($Qty),
				mysql_real_escape_string($TicketID));
			mysql_query($update);
			
			$update = sprintf("update cart_items set TransactionID = '%s', PayPalTime = '%s', OrderTime = NOW(), Status = 1 where Status = 0 and UserID = '%s' and ID = '%s'",
				mysql_real_escape_string($transactionId),
				mysql_real_escape_string($orderTime),
				mysql_real_escape_string($UserID),
				mysql_real_escape_string($CartID));
			//echo $update . "<br><br>";
			mysql_query($update);	
			
			$insert = sprintf("INSERT INTO transactions (UserID, TransactionId, Type, Amount, TransactionDate) VALUES ('%s', '%s', '%s', '%s', NOW())",
				mysql_real_escape_string($SellerID),
				mysql_real_escape_string($transactionId),
				mysql_real_escape_string("Pending"),
				mysql_real_escape_string($TicketAmt));
			//echo $insert . "<br><br>";
			mysql_query($insert);
			
			$insert = sprintf("INSERT INTO balance (UserID, PendingBalance) VALUES (%s,%s) ON DUPLICATE KEY UPDATE PendingBalance=PendingBalance+%s",
				mysql_real_escape_string($SellerID),
				mysql_real_escape_string($TicketAmt),
				mysql_real_escape_string($TicketAmt));
			//echo $insert . "<br><br>";
			mysql_query($insert);	 
		}
			
		$insert = sprintf("INSERT INTO transactions (UserID, TransactionId, Type, Amount, TransactionDate) VALUES ('%s', '%s', '%s', '%s', NOW())",
			mysql_real_escape_string(0),
			mysql_real_escape_string($transactionId),
			mysql_real_escape_string("Credit"),
			mysql_real_escape_string($amt));
		//echo $insert . "<br><br>";
		mysql_query($insert);
		
		$insert = sprintf("INSERT INTO balance (UserID, Balance) VALUES (%s,%s) ON DUPLICATE KEY UPDATE Balance=Balance+%s",
			mysql_real_escape_string(0),
			mysql_real_escape_string($amt),
			mysql_real_escape_string($amt));
		//echo $insert . "<br><br>";
		mysql_query($insert);	
		
		$_SESSION["Payment_Amount"] = "";
		$_SESSION["Payment_Qty"] = "";
		$_SESSION["OrderItems"] = "";
		
		
		header("Location: /order.php?ID=" . $transactionId);
	}
	else  
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
		$ShowError = 1;
	}
}		
else
{
	$transactionId = $OrderID ;
	$_SESSION['TransactionId'] = $transactionId;
}


	$sql = sprintf("select * from orders where TransactionId = '%s'",
			mysql_real_escape_string($transactionId));
	$results = mysql_query($sql);
	
	while($row = mysql_fetch_array($results)) {
		$id = $row['id'];
		$UserID = $row['UserID'];
		$UserInfoId = $row['UserInfoId'];
		$TransactionId = $row['TransactionId'];
		$TransactionType = $row['TransactionType'];
		$PaymentType = $row['PaymentType'];
		$PayPalTime = $row['PayPalTime'];
		$Amt = $row['Amt'];
		$CurrencyCode = $row['CurrencyCode'];
		$FeeAmt = $row['FeeAmt'];
		$TaxAmt = $row['TaxAmt'];
		$PaymentStatus = $row['PaymentStatus'];
		$PendingReason = $row['PendingReason'];
		$ReasonCode = $row['ReasonCode'];
		$SellerApprove = $row['SellerApprove'];
		$BuyerApprove = $row['BuyerApprove'];
		$OrderItems = $row['OrderItems'];
		$resArray = $row['resArray'];
		$OrderTime = $row['OrderTime'];		
	}
	
	$OrderTime = new DateTime($OrderTime);


	$sql = sprintf("select * from user_info where UserID = '%s' and EndDate is null",
			mysql_real_escape_string($UserID));
	$results = mysql_query($sql);
	
	while($row = mysql_fetch_array($results)) {
		$UserInfoId = $row['id'];
		$FirstName = $row['FirstName'];
		$LastName = $row['LastName'];
		$Address1 = $row['Address1'];
		$Address2= $row['Address2'];
		$City = $row['City'];
		$State = $row['State'];
		$Zip = $row['Zip'];
		$Phone = $row['Phone'];
		$Email = $row['Email'];
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
                
                <?php 
				if ($ShowError == 1) 
				{
					
				?>
                
                    <div id="section-header">

                        <?php include($_SERVER['DOCUMENT_ROOT']."/include/template/search.php");  ?>

                        <h1 id="section-title">Order Error</h1>
                        <h2 id="section-desc">There was a problem with your order.  Please review the below information and contact us if you have any questions.</h2>
                    </div>
                    
                    <div class="event-title">Error Information</div>
                    <div id="cart-info" style="background-color: #fff; padding: 20px; font-size: 12px;">
                        
                        <div class="alert alert-error">
                        	GetExpressCheckoutDetails API call failed.
                        </div>
                    
                        <blockquote>
                        <?php 
                            echo "Detailed Error Message: " . $ErrorLongMsg . "<br />";
                            echo "Short Error Message: " . $ErrorShortMsg . "<br />";
                            echo "Error Code: " . $ErrorCode . "<br />";
                            echo "Error Severity Code: " . $ErrorSeverityCode . "<br />";
                        ?>
                        </blockquote>
                        
						<span class="label label-important">IMPORTANT</span> Nothing has been charged to your PayPal Account.  If you would like to try your order again, please <a href="/checkout.php">click here</a> to review your information and try checking out again.  If this problems persists please contact us for help.
                        
                        <div style="text-align: center; margin-top: 20px;">
	                        <button class="btn btn-large btn-block btn-inverse" type="button" onclick="window.location = '/checkout.php';">Return to Your Cart!</button>
                        </div>
                    </div>
                <?php 
				}
				else
				{
				?>
                    
                    <div id="section-header">

                        <?php include($_SERVER['DOCUMENT_ROOT']."/include/template/search.php");  ?>

                        <h1 id="section-title">Order Complete</h1>
                        <h2 id="section-desc">Transaction #: <?php echo $transactionId ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Order Date: <?php echo $OrderTime->format('m/d/Y g:i A'); ?></h2>
                    </div>
                    
                
                    <div class="event-title">Your Order</div>
                    <div id="cart-info" style="background-color: #fff; padding: 20px; font-size: 12px;">
                        
                        <div id="checkout-tickets-list">
                        
                            <?php
							$Total = 0;
							$Fee = 0;
							$showTixx = 0;
							$showFedEx = 0;
							$showWillCall = 0;
							$showContact = 0;
							$showMuliple = 0;
							
                            $json = $OrderItems;
                            $JSON = json_decode($json,true);
                            foreach ($JSON["items"] as $key => $value) {
                                $CartID= $JSON["items"][$key]["CartID"];
                                $TicketID = $JSON["items"][$key]["TicketID"];
                                $Qty = $JSON["items"][$key]["Qty"];
                                $Price = $JSON["items"][$key]["Price"];
                                $Price = $JSON["items"][$key]["Price"];
                                $SellerID = $JSON["items"][$key]["SellerID"];
                                
                                $sql = sprintf("SELECT
                                                        c.id as CartID,
                                                        e.EventID,
                                                        v.VenueID,
                                                        t.id as TicketID,
                                                        c.Qty,
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
                                                        u.username,
                                                        u.fullname,
                                                        e.Title as EventTitle,
                                                        e.Description as EventDesc,
                                                        e.SourceUrl as EventURL,
                                                        e.StartTime,
                                                        v.Name as VenueName,
                                                        v.Address,
                                                        v.City,
                                                        v.Region as State
                                                    from 
                                                        cart_items c
                                                        inner join tickets t on c.TicketID = t.id
                                                        inner join data_events e on t.EventID = e.EventID
                                                        inner join data_venues v on e.VenueID = v.VenueID
                                                        inner join users u on t.AddedBy = u.id
                                                    where 
                                                        c.id = '%s'", 	
                                mysql_real_escape_string($CartID));	
								if ($Debug != "")
								{
									echo "".$sql."";
								}
                                $results = mysql_query($sql);
                                
                                
                                while($row = mysql_fetch_array($results)) {
                                    $UserInfoId = $row['UserInfoId'];
                                    $CartID = $row['CartID'];
                                    $EventID = $row['EventID'];
                                    $VenueID = $row['VenueID'];
                                    $TicketID = $row['TicketID'];
                                    $Qty = $row['Qty'];
                                    $Price = $row['Price'];
                                    $SubTotal = floatval($Qty) * floatval($Price);
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
                                    $EventTitle = $row['EventTitle'];
                                    $EventDesc = $row['EventDesc'];
                                    $Category = $row['Category'];
                                    $EventURL = $row['EventURL'];
                                    $StartTime = $row['StartTime'];
                                    $VenueName = $row['VenueName'];
                                    $Address = $row['Address'];
                                    $City = $row['City'];
                                    $State = $row['State'];
                                    
                                    $StartDate = new DateTime($StartTime);
                                    $TheDate = $StartDate->format('m/d/Y');
                                    $TheTime = " at " . $StartDate->format('H:i:s');
                                    if ($TheTime = "00:00:00")
                                    {
                                        $TheTime = "";	
                                    }
                                }
								
								$SubTotal = (floatval($Qty) * floatval($Price));
                                ?>
                                
                                <div id="checkout-template">
                                    <div id="Cart-%TicketID%" class="cart-item">
                                        <div class="position">
                                            <?php echo $key + 1 ?>
                                        </div>
                                        <div class="info">
                                            
                                            <div class="info-box">
                                                
                                                <div>
                                                <h2><?php echo $EventTitle ?> @ <?php echo $VenueName ?></h2>
                                                <h3>
													<?php echo $City ?>, <?php echo $State ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $TheDate ?> <?php echo $TheTime ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Seller Username: <?php echo $username ?>
                                                	
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
                                                <div style="width: 175px; float: left;">
                                                    <b><?php echo $TicketDesc ?></b>
                                                </div>
                                                <div style="width: 165px; float: left;">
                                                    <b>Qty: </b><?php echo $Qty ?>
                                                </div>
                                                <div style="width: 175px; float: left;">
                                                    <b>Price: </b> <div style="float: right;">$<?php echo $Price ?></div>
                                                </div>
                                                <div style="width: 175px; float: right; margin-left: 59px; padding-right: 10px;">
                                                    <b>SubTotal: </b> <div style="float: right;">$<?php echo $SubTotal ?></div>
                                                </div>
                                                <div class="controls" style="display:none">
                                                    <li class="no-border" onclick="deleteFromCart(%CartID%, 'checkout');" style="color: #BD1E2D;"><img src="/images/icon_delete.png" height="10" /></li>
                                                </div>
                                                
                                                
                                                <div style="clear: both; display: none;">
                                                    Section: <?php echo $Section ?>&nbsp;&nbsp;&nbsp;&nbsp;Row: <?php echo $Row ?>&nbsp;&nbsp;&nbsp;&nbsp;Seats: <?php echo $Seats ?>
                                                </div>
                                                <div style="clear: both; display:none;">
                                                    <?php echo $AdditionalInfo ?>
                                                </div>
                                            </div>
                                            
                                            
                                        </div>
                                        
                                    
                                    </div>
                                    <div style="clear:both;"></div>
                                
                                </div>
                                
                                <?php
								
								$Total = $Total + $SubTotal;
                            }
							
							$Fee = ($Total + 1) * 0.04;
							$Total = ($Total + 1) * 1.04;
                            ?>
                                
                        
                        
                        
                        </div>
                        <div id="checkout-service-charge-display" style="clear:both;">
                            <div style="float: right; padding-right: 10px;">$1.00</div>
                            <div style="float: right; font-style; padding: 0 92px;">TixxFixx.com Service Charge:</div>
                        </div>
                        <div id="checkout-processing-fee" style="clear:both;">
                            <div id="checkout-fee" style="float: right; padding-right: 10px;">$<?php echo number_format($Fee, 2, '.', ''); ?></div>
                            <div style="float: right; font-style; padding: 0 92px;">4% Credit Card Processing Fee:</div>
                        </div>
                        <div id="checkout-total-display" style="clear:both; font-size: 15px; border-top: 1px dotted #000; width: 300px; float:right; margin-top: 10px;padding-top: 10px;">
                            <div id="checkout-total" style="float: right; font-weight: bold; padding-right: 10px;">$<?php echo number_format($Total, 2, '.', ''); ?></div>
                            <div style="float: right; font-style; padding: 0 92px; font-weight: bold;">Total:</div>
                        </div>
                        
                        <div style="clear:both;"></div>
                    </div>
                 
                    <br />
                    
                    <div id="checkout-info"  style="width: 400px; float: left;">
                        <div class="event-title">Your Information</div>
                        <div id="content">
                            
                             
                                <form class="form-horizontal" style="clear: both;">
                                    <div class="control-group">
                                        <label class="control-label" for="FirstName">First Name:</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $FirstName ?>" id="FirstName" name="FirstName" placeholder="First Name" onchange="validateInfo();" disabled />
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">
                                        <label class="control-label" for="LastName">Last Name:</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $LastName ?>" id="LastName" name="LastName" placeholder="Last Name" onchange="validateInfo();" disabled />
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">        
                                        <label class="control-label" for="Address1">Address 1:</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $Address1 ?>" id="Address1" name="Address1" placeholder="Address Line 1" onchange="validateInfo();" disabled />
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">        
                                        <label class="control-label" for="Address2">Address 2:</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $Address2 ?>" id="Address2" name="Address2" placeholder="" onchange="validateInfo();" disabled />
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">        
                                        <label class="control-label" for="City">City:</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $City ?>" id="City" name="City" placeholder="City" onchange="validateInfo();" disabled />
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">        
                                        <label class="control-label" for="State">State:</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $State ?>" id="State" name="State" placeholder="State" onchange="validateInfo();" disabled />
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">        
                                        <label class="control-label" for="Zip">Zip:</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $Zip ?>" id="Zip" name="Zip" placeholder="Zip" onchange="validateInfo();" disabled />
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">        
                                        <label class="control-label" for="Phone">Phone:</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $Phone ?>" id="Phone" name="Phone" placeholder="Phone Number" onchange="validateInfo();" disabled />
                                        </div>
                                    </div>
                                        
                                    <div class="control-group">        
                                        <label class="control-label" for="Email">Email:</label>
                                        <div class="controls">
                                            <input type="text" value="<?php echo $Email ?>" id="Email" name="Email" placeholder="Email Address" onchange="validateInfo();" disabled />
                                        </div>
                                    </div>
                                        
                                </form>
                        </div>
                    </div>
                    
                    <div id="checkout-delivery"  style="width: 400px; float: right;">
                        <div class="event-title">Delivery Information</div>
                        <div id="content">
                        	<?php if ($showMuliple == 1) { ?>
                                <div id="delivery-eTixx">
                                    <b>Mulitple Delivery Options</b><br />
                                    There are multiple delivery options associated with your order.  This might be because you have purchesed tickets from more then one seller in a single order.  Please review each order item for instructions on how these tickets will be delivered to you.
                                </div>
                            <?php } else { ?>
								<?php if ($showTixx == 1) { ?>
                                <div id="delivery-eTixx">
                                    <b>eTixx Ticketing Service</b><br />
                                    The seller for the tickets in your order has elected to use TixxFixx eTixx Services.  What this means is the money for this order has been placed in the TixxFixx Escrow Account on PayPal.  Once you have printed your eTixx from TixxFixx the money will be released to the seller.   You will be able to review your order and communicate with the seller at anytime under the My Orders Section of TixxFixx.com.
                                    
									<div style="text-align: center; margin-top: 20px;">
                                    	<button class="btn btn-large btn-inverse" type="button" onclick="window.location='print.php?ID=4U586475UX422421A';">Print Your Tickets</button>
                                    </div>                                  
                                    
                                </div>
                                <?php } ?>
                                <?php if ($showWillCall == 1) { ?>
                                <div id="delivery-willcall">
                                    <b>Will Call</b><br />
                                    Your tickets will be available at Will Call on the evening of the event. Please bring your identification and arrive no earlier than 1 hour prior to show time. Thank you for your order and enjoy your event.
                                </div>
                                <?php } ?>
                                <?php if ($showContact == 1) { ?>
                                <div id="delivery-contact">
                                    <b>Make Your Own Arragments</b><br />
                                    The seller has elected to contact you directly to make arrangment for the delivery of your tickets.  The money for this order has been placed in the TixxFixx Escrow Account on PayPal.  Once you have received your tickets the money will be released to the seller.    You will be able to review your order and communicate with the seller at anytime under the My Tickets Section of TixxFixx.com.
                                </div>
                                <?php } ?>
							<?php } ?>	
                        </div>
                    </div>
                    
                    <div id="checkout-delivery"  style="width: 400px; float: right; margin-top: 20px;">
                        <div class="event-title">PayPal Payment Information</div>
                        <div id="content">
                        
                            <form class="form-horizontal" style="clear: both;">
                                <div class="control-group">
                                    <label class="control-label" for="TransactionId">Transaction #:</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $TransactionId ?>" id="TransactionId" name="TransactionId" disabled />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="PayPalTime">Order Time:</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $PayPalTime ?>" id="PayPalTime" name="PayPalTime" disabled />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="PayPalTime">Payment Amount:</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $Amt ?>" id="Amt" name="Amt" disabled />
                                    </div>
                                </div>
                                
                                <div class="control-group">
                                    <label class="control-label" for="PaymentStatus">PaymentStatus:</label>
                                    <div class="controls">
                                        <input type="text" value="<?php echo $PaymentStatus ?>" id="PaymentStatus" name="PaymentStatus" disabled />
                                    </div>
                                </div>
                                    
                            </form>
                        
                        </div>
                    </div>
                <?php } ?>
                <br style="clear: both;" />
                        
            </div>
            
		</div>   
    
   		<div id="footer" style="margin: -198px 0 0; padding: 358px 0 0;"><?php include($_SERVER['DOCUMENT_ROOT']."/include/template/footer.php");  ?></div>	
    </div>
    

</body>
</html>


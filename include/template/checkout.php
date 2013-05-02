<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php

//Always place this code at the top of the Page
session_start();
$showConfirm = 0;

/*==================================================================
 PayPal Express Checkout Call
 ===================================================================
*/
// Check to see if the Request object contains a variable named 'token'	
$token = "";
if (isset($_REQUEST['token']))
{
	$token = $_REQUEST['token'];
}

// If the Request object contains the variable 'token' then it means that the user is coming from PayPal site.	
if ( $token != "" )
{

	require_once ("/Classes/paypal/paypalfunctions.php");

	/*
	'------------------------------------
	' Calls the GetExpressCheckoutDetails API call
	'
	' The GetShippingDetails function is defined in PayPalFunctions.jsp
	' included at the top of this file.
	'-------------------------------------------------
	*/
	

	$resArray = GetShippingDetails( $token );
	
	$ack = strtoupper($resArray["ACK"]);
	if( $ack == "SUCCESS" || $ack == "SUCESSWITHWARNING") 
	{
	
		/*
		' The information that is returned by the GetExpressCheckoutDetails call should be integrated by the partner into his Order Review 
		' page		
		*/
		$PP_email 				= $resArray["EMAIL"]; // ' Email address of payer.
		$PP_payerId 			= $resArray["PAYERID"]; // ' Unique PayPal customer account identification number.
		$PP_payerStatus			= $resArray["PAYERSTATUS"]; // ' Status of payer. Character length and limitations: 10 single-byte alphabetic characters.
		$PP_salutation			= $resArray["SALUTATION"]; // ' Payer's salutation.
		$PP_firstName			= $resArray["FIRSTNAME"]; // ' Payer's first name.
		$PP_middleName			= $resArray["MIDDLENAME"]; // ' Payer's middle name.
		$PP_lastName			= $resArray["LASTNAME"]; // ' Payer's last name.
		$PP_suffix				= $resArray["SUFFIX"]; // ' Payer's suffix.
		$PP_cntryCode			= $resArray["COUNTRYCODE"]; // ' Payer's country of residence in the form of ISO standard 3166 two-character country codes.
		$PP_business			= $resArray["BUSINESS"]; // ' Payer's business name.
		$PP_shipToName			= $resArray["SHIPTONAME"]; // ' Person's name associated with this address.
		$PP_shipToStreet		= $resArray["SHIPTOSTREET"]; // ' First street address.
		$PP_shipToStreet2		= $resArray["SHIPTOSTREET2"]; // ' Second street address.
		$PP_shipToCity			= $resArray["SHIPTOCITY"]; // ' Name of city.
		$PP_shipToState			= $resArray["SHIPTOSTATE"]; // ' State or province
		$PP_shipToCntryCode		= $resArray["SHIPTOCOUNTRYCODE"]; // ' Country code. 
		$PP_shipToZip			= $resArray["SHIPTOZIP"]; // ' U.S. Zip code or other country-specific postal code.
		$PP_addressStatus 		= $resArray["ADDRESSSTATUS"]; // ' Status of street address on file with PayPal   
		$PP_invoiceNumber		= $resArray["INVNUM"]; // ' Your own invoice or tracking number, as set by you in the element of the same name in SetExpressCheckout request .
		$PP_phonNumber			= $resArray["PHONENUM"]; // ' Payer's contact telephone number. Note:  PayPal returns a contact telephone number only if your Merchant account profile settings require that the buyer enter one. 

		$showConfirm = 1;
	} 
	else  
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
		
		echo "GetExpressCheckoutDetails API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
}
	

	
$UserID = $_SESSION['id'];
$sql = sprintf("select * from user_info where UserID = '%s' and EndDate is null",
		mysql_real_escape_string($UserID));
$results = mysql_query($sql);

while($row = mysql_fetch_array($results)) {
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
            
                
    <div id="section-selector">
        <a href="<?php echo $_SESSION['location_url'] ?>/events" class="section-selector-item margin-right blue_1">Events<div style="font-size: 11px;">All the local events and tickets you need</div></a>
        <a href="/sales.php" class="section-selector-item margin-right blue_2">My Sales<div style="font-size: 11px;">View and manage all your tickets, sales and revenues</div></a>
        <a href="/orders.php" class="section-selector-item blue_3">My Orders<div style="font-size: 11px;">Review the status of tickets you have purchased</div></a>
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
        <h1 id="section-title">Checkout</h1>
        <h2 id="section-desc"></h2>
    </div>
    
    
    <div id="checkout-template" style="display: none;">
        <div id="Cart-%TicketID%" class="cart-item">
            <div id="Cart-CartID-%CartID%" class="hidden">%CartID%</div>
            <div id="Cart-EventID-%CartID%" class="hidden">%EventID%</div>
            <div id="Cart-VenueID-%CartID%" class="hidden">%VenueID%</div>
            <div id="Cart-TicketID-%CartID%" class="hidden">%TicketID%</div>
            <div id="Cart-Qty-%CartID%" class="hidden">%Qty%</div>
            <div id="Cart-Price-%CartID%" class="hidden">%Price%</div>
            <div id="Cart-SubTotal-%CartID%" class="hidden">%SubTotal%</div>
            <div id="Cart-TicketType-%CartID%" class="hidden">%TicketType%</div>
            <div id="Cart-TicketDesc-%CartID%" class="hidden">%TicketDesc%</div>
            <div id="Cart-Section-%CartID%" class="hidden">%Section%</div>
            <div id="Cart-Row-%CartID%" class="hidden">%Row%</div>
            <div id="Cart-Seats-%CartID%" class="hidden">%Seats%</div>
            <div id="Cart-AdditionalInfo-%CartID%" class="hidden">%AdditionalInfo%</div>
            <div id="Cart-EventTitle-%CartID%" class="hidden">%EventTitle%</div>
            <div id="Cart-EventDesc-%CartID%" class="hidden">%EventDesc%</div>
            <div id="Cart-Category-%CartID%" class="hidden">%Category%</div>
            <div id="Cart-EventURL-%CartID%" class="hidden">%EventURL%</div>
            <div id="Cart-StartTime-%CartID%" class="hidden">%StartTime%</div>
            <div id="Cart-VenueName-%CartID%" class="hidden">%VenueName%</div>
            <div id="Cart-Address-%CartID%" class="hidden">%Address%</div>
            <div id="Cart-City-%CartID%" class="hidden">%City%</div>
            <div id="Cart-State-%CartID%" class="hidden">%State%</div>
            <div id="Cart-Expire-%CartID%" class="hidden">%Expire%</div>
            <div class="position">
                %Cnt%
            </div>
            <div class="info">
                
                <div class="controls" style="margin-right: 20px;">
                    <li class="no-border" onclick="deleteFromCart(%CartID%, 'checkout');" style="color: #BD1E2D;"><img src="/images/icon_delete.png" height="10" /></li>
                </div>
                <div class="info-box">
                	
                    <div>
                	<h2>%EventTitle% @ %VenueName%</h2>
                    
                
                    <h3>%City%, %State%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%StartDateFormated%&nbsp;&nbsp;%StartTimeFormated%</h3>
                    </div>
                    <div style="width: 175px; float: left;">
                        <b>%TicketDesc%</b>
                    </div>
                    <div style="width: 165px; float: left;">
                        <b>Qty: </b>%Qty%
                    </div>
                    <div style="width: 175px; float: left;">
                        <b>Price: </b> <div style="float: right;">$%Price%</div>
                    </div>
                    <div style="width: 175px; float: right; margin-left: 59px; padding-right: 10px;">
                        <b>SubTotal: </b> <div style="float: right;">$%SubTotal%</div>
                    </div>
                    
                    
                    <div style="clear: both; %ShowRowSeat%">
                        Section: %Section%&nbsp;&nbsp;&nbsp;&nbsp;Row: %Row%&nbsp;&nbsp;&nbsp;&nbsp;Seats: %Seats%
                    </div>
                    <div style="clear: both; display:none;">
                        %AdditionalInfo%
                    </div>
                </div>
                
            </div>
            
        
        </div>
        <div style="clear:both;"></div>
    
    </div>

	<div class="event-title">Your Shopping Cart</div>
    <div id="cart-info" style="background-color: #fff; padding: 20px; font-size: 12px;">
    	
	    <div id="checkout-tickets-list"></div>
    	<div id="checkout-service-charge-display" style="clear:both;">
            <div style="float: right; padding-right: 10px;">$1.00</div>
        	<div style="float: right; font-style; padding: 0 92px;">TixxFixx.com Service Charge:</div>
        </div>
        <div id="checkout-processing-fee" style="clear:both;">
            <div id="checkout-fee" style="float: right; padding-right: 10px;"></div>
            <div style="float: right; font-style; padding: 0 92px;">4% Credit Card Processing Fee:</div>
        </div>
    	<div id="checkout-total-display" style="clear:both; display: none; font-size: 15px; border-top: 1px dotted #000; width: 300px; float:right; margin-top: 10px;padding-top: 10px;">
            <div id="checkout-total" style="float: right; font-weight: bold; padding-right: 10px;"></div>
        	<div style="float: right; font-style; padding: 0 92px; font-weight: bold;">Total:</div>
        </div>
        
        <div style="clear:both;"></div>
    </div>
    <script>
		getCheckout();
	</script>
    
    <br />
    
    <div id="checkout-info"  style="width: 400px; float: left;">
        <div class="event-title">Your Information</div>
        <div id="content">
            
            <?php if ($showConfirm == 0) { ?>
                
                <form class="form-horizontal" style="clear: both;">
                    <div class="control-group">
                        <label class="control-label required" for="FirstName">* First Name:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $FirstName ?>" id="FirstName" name="FirstName" placeholder="First Name" onchange="validateInfo();" required />
                        </div>
                    </div>
                        
                    <div class="control-group">
                        <label class="control-label required" for="LastName">* Last Name:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $LastName ?>" id="LastName" name="LastName" placeholder="Last Name" onchange="validateInfo();" required />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="Address1">* Address 1:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $Address1 ?>" id="Address1" name="Address1" placeholder="Address Line 1" onchange="validateInfo();" required />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label" for="Address2">Address 2:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $Address2 ?>" id="Address2" name="Address2" placeholder="Address Line 2" onchange="validateInfo();" />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="City">* City:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $City ?>" id="City" name="City" placeholder="City" onchange="validateInfo();" required />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="State">* State:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $State ?>" id="State" name="State" placeholder="State" onchange="validateInfo();" required />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="Zip">* Zip:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $Zip ?>" id="Zip" name="Zip" placeholder="Zip" onchange="validateInfo();" required />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="Phone">* Phone:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $Phone ?>" id="Phone" name="Phone" placeholder="Phone Number" onchange="validateInfo();" required />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="Email">* Email:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $Email ?>" id="Email" name="Email" placeholder="Email Address" onchange="validateInfo();" required />
                        </div>
                    </div>
                        
                </form>
			<?php 
			}
			else
			{		
			 ?> 
			 
                <form class="form-horizontal" style="clear: both;">
                    <div class="control-group">
                        <label class="control-label required" for="FirstName">* First Name:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $FirstName ?>" id="FirstName" name="FirstName" placeholder="First Name" onchange="validateInfo();" disabled />
                        </div>
                    </div>
                        
                    <div class="control-group">
                        <label class="control-label required" for="LastName">* Last Name:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $LastName ?>" id="LastName" name="LastName" placeholder="Last Name" onchange="validateInfo();" disabled />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="Address1">* Address 1:</label>
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
                        <label class="control-label required" for="City">* City:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $City ?>" id="City" name="City" placeholder="City" onchange="validateInfo();" disabled />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="State">* State:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $State ?>" id="State" name="State" placeholder="State" onchange="validateInfo();" disabled />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="Zip">* Zip:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $Zip ?>" id="Zip" name="Zip" placeholder="Zip" onchange="validateInfo();" disabled />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="Phone">* Phone:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $Phone ?>" id="Phone" name="Phone" placeholder="Phone Number" onchange="validateInfo();" disabled />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="Email">* Email:</label>
                        <div class="controls">
                            <input type="text" value="<?php echo $Email ?>" id="Email" name="Email" placeholder="Email Address" onchange="validateInfo();" disabled />
                        </div>
                    </div>
                        
                </form>
			<?php 
			}
			?> 
        </div>
    </div>
    
    <div id="checkout-delivery"  style="width: 400px; float: right;">
        <div class="event-title">Delivery Information</div>
        <div id="content">
            <div id="delivery-eTixx" style="display: none;">
            	<b>eTixx Ticketing Service</b><br />
                The seller has elected to use TixxFixx eTixx Services.  What this means is the money for this order will be placed in the TixxFixx Escrow Account on PayPal.  Once you have received your eTixx from TixxFixx for this event in your email the money will be released to the seller.   You will be able to review your order and communicate with the seller at anytime under the My Tickets Section of TixxFixx.com.
            </div>
            <div id="delivery-willcall" style="display: none;">
            	<b>Will Call</b>
                Your tickets will be available at Will Call on the evening of the event. Please bring your identification and arrive no earlier than 1 hour prior to show time. Thank you for your order and enjoy your event.
            </div>
            <div id="delivery-eTixx" style="display: none;">
            	<b>Make Your Own Arragments</b><br />
                The seller has elected to contact you directly to make arrangment for the delivery of your tickets.  Once your order is place the money for this order will be placed in the TixxFixx Escrow Account on PayPal.  Once you have received you have confirmed that you have recieved your tickets the money will be released to the seller.    You will be able to review your order and communicate with the seller at anytime under the My Tickets Section of TixxFixx.com.
            </div>
			
            <?php if ($showConfirm == 0) { ?>
                <label class="checkbox" style="margin-top: 20px; font-size: 11px;">
                    <input type="checkbox" id="Agree-Delivery" name="Agree-Delivery" value="true" onclick="validateInfo();">
                    <b>I have read and understand the above delivery information</b>
                </label>
			<?php } ?>

        </div>
    </div>
    
    <div id="checkout-delivery"  style="width: 400px; float: right; margin-top: 20px;">
        <div class="event-title">Payment Information</div>
        <div id="content">
            
            <div id="validate-info">Please make sure all the required fields to the left are filled out correctly and that you have checked the box above before continuing.</div>
            <div id="paypal-checkout" style="display: none;">
             
            <?php if ($showConfirm == 0) { ?>
                <div style="text-align:center;">
                <form action="/Classes/paypal/expresscheckout.php" METHOD="POST">
	               	<input id="Payment_Qty" type="hidden" value="" name="Payment_Qty">
	               	<input id="Payment_Amount" type="hidden" value="" name="Payment_Amount">
	               	<input id="OrderItems" type="hidden" value="" name="OrderItems">
                	<input type="image" name="submit" src="https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif" border="0" align="top" alt="Check out with PayPal"/>
                </form>
                 </div>

                <b>Why must I use PayPal?</b><br />This is one of our most frequently asked
                questions. While developing the TixxFixx platform, we wanted to adopt
                the most robust, forward thinking and safest possible websites on the
                market today. Even with the increasing state and federal regulations
                regarding consumer protection, consumer/credit card fraud is an
                exponentially growing problem. By using PayPal, we never see your
                credit card. We eliminate the potential of in-house and cyber fraud by
                eliminating any potential threat of fraud. This removes TixxFixx and a
                3rd party cc processing company of handling your private information
                and streamlines our checkout process, decreases fees, and protects you
                the consumer, to the maximum amount. In a word, any fraud worries,
                have been Fixxed.
                 
			<?php 
			}
			else
			{		
			?> 
			            
                <form class="form-horizontal" action="order.php" METHOD="POST" style="clear: both;">
                    <div class="control-group">        
                        <label class="control-label required" for="Zip" style="width: 110px;">PayPal Account:</label>
                        <div class="controls" style="margin-left: 135px;">
                            <input type="text" value="<?php echo $PP_email ?>" id="PayPal_Username" name="PayPal_Username" placeholder="PayPal Username" disabled />
                        </div>
                    </div>
                        
                    <div class="control-group">        
                        <label class="control-label required" for="Zip" style="width: 110px;">PayPal Name:</label>
                        <div class="controls" style="margin-left: 135px;">
                            <input type="text" value="<?php echo $PP_firstName . " " . $PP_lastName ?>" id="PayPal_Email" name="PayPal_Email" placeholder="PayPal Email" disabled />
                        </div>
                    </div>
                        
                    <div class="control-group" style="display: none;">        
                        <label class="control-label required" for="Zip" style="width: 110px;">Order Itmes:</label>
                        <div class="controls" style="margin-left: 135px;">
                            <input type="text" value="<?php echo $_SESSION["OrderItems"] ?>" id="OrderItems" name="OrderItems" placeholder="Order Items" disabled />
                        </div>
                    </div>
                            
                    <div class="control-group">   
                        <div class="controls" style="margin-left: 135px;">
	                    	<input class="btn btn-inverse" type="submit" value="Complete Order"/>
                        </div>
                    </div>
                    </form>
                    
                    <script>
						$("#validate-info").hide();
						$("#paypal-checkout").show();
					</script>
			<?php 
			}
			?> 
            </div>
            
        </div>
    </div>
    
    <br style="clear: both;" />
    

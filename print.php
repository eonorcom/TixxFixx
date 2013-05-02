<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php

session_start();
$OrderID = $_GET["ID"];
$transactionId = $OrderID ;
$_SESSION['TransactionId'] = $transactionId;


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
<body style="background: none;">

        
    
    	<div id="ticket_page">
    		
                    <div id="etixx">
                        
                        
                            <?php
							$showTixx = 0;
							$showFedEx = 0;
							$showWillCall = 0;
							$showContact = 0;
							$showMuliple = 0;
							
                            $json = $OrderItems;
                            $JSON = json_decode($json,true);
                            foreach ($JSON["items"] as $key => $value) {
                                $CartID = $JSON["items"][$key]["CartID"];
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
                                                        c.Qty * t.Price as SubTotal,
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
                                                        e.EventTitle,
                                                        e.EventDesc,
                                                        e.Category,
                                                        e.EventURL,
                                                        e.StartTime,
                                                        v.VenueName,
                                                        v.Address,
                                                        v.City,
                                                        v.State
                                                    from 
                                                        cart_items c
                                                        inner join tickets t on c.TicketID = t.id
                                                        inner join events e on t.EventID = e.EventID
                                                        inner join venues v on e.VenueID = v.VenueID
                                                        inner join users u on t.AddedBy = u.id
                                                    where 
                                                        c.id = '%s'", 		
                                mysql_real_escape_string($CartID));
                                $results = mysql_query($sql);
                                
                                
                                while($row = mysql_fetch_array($results)) {
                                    $UserInfoId = $row['UserInfoId'];
                                    $CartID = $row['CartID'];
                                    $EventID = $row['EventID'];
                                    $VenueID = $row['VenueID'];
                                    $TicketID = $row['TicketID'];
                                    $Qty = $row['Qty'];
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
								
                                ?>
                                
                                <div id="ticket-template" style="font-size: 9px;">
                                	<div style=" position:relative; z-index:100">
                                        <div id="ticket-<?php echo $TransactionId . "-" . $CartID . "-" . strval($key + 1) ?>">
                                            <div style="width: 371px; margin: 123px 0 0 62px; float: left; text-align: right;">
                                                
                                                <div style="padding: 20px 10px 0 0 ; height: 77px; font-size:22px;"><?php echo $EventTitle ?></div>
                                                <div style="padding: 20px 10px 0 0 ; margin-top: 2px; height: 21px;"><?php echo $TheDate ?> <?php echo $TheTime ?></div>
                                                <div style="padding: 20px 10px 0 0 ; margin-top: 2px; height: 21px;"><?php echo $TicketDesc ?></div>
                                                <div style="padding: 20px 10px 0 0 ; margin-top: 2px; height: 23px;"><?php echo $VenueName ?> in <?php echo $City ?>, <?php echo $State ?></div>
                                                <div style="padding: 10px 10px 0 0 ; margin-top: 2px; height: 18px;">Purchased from <b>TixxFixx.com</b> for <b>$<?php echo $Price ?></b>.  Order ID# <?php echo $TransactionId ?></div>
                                                
                                            </div> 
                                            <div style="width: 149px; margin: 123px 62px 0 0; float: right; text-align: right">
                                                <div id="ticketID" style="padding: 20px 10px 0 0 ; height: 22px;"><?php echo $TransactionId . "-" . $CartID . "-" . $Qty ?>-1</div>
                                                <div style="padding: 15px 10px 0 0 ; margin-top: 5px; height: 35px;"><?php echo $FirstName . " " . $LastName ?></div>
                                            </div>                                      
                                        </div>
                                        <div style="clear:both;"></div>
                                        
                                        <div style="border: 1px solid #b4b4b1; width: 400px; padding: 10px; margin: 40px 0 0 171px;">
                                            <div style="text-align:center;">
                                                TixxFixx.com eTixx Ticket ID#
                                                <img id="barCode" src="http://tixx/Classes/barcode/gen.php?ID=<?php echo $TransactionId . "-" . $CartID . "-" . $Qty ?>-1" />
                                            </div>
                                        </div>
                                    </div>
                                	<div style="top: -505px; position: relative; z-index:1"><img src="/images/etixx_bg.png" /></div>
                                </div>
                                
                                <?php
                            }
                            ?>
                        
                        
                        <div style="clear:both;"></div>
                    
            </div>
            
    
    </div>
    
    <!-- Modal -->
    <div id="printDiag" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <h3 id="myModalLabel">Printing Tickets <span id="PrintCount">1</span> of <?php echo $Qty ?></h3>
      </div>
      <div class="modal-body">
        <p>One fine body…</p>
      </div>
      <div class="modal-footer">
        <button id="printButton" class="btn btn-inverse" onclick="cntPrints();">Print Ticket</button>
      </div>
    </div>
    <script>
	
	var cnt = 0;
	var maxCnt = <?php echo $Qty ?>;
	var partialTicketID = "<?php echo $TransactionId . "-" . $CartID . "-" . $Qty ?>"
	function cntPrints()
	{
		cnt++;
		var TicketID = partialTicketID + "-" + cnt;
		$("#PrintCount").html(cnt);
		$("#ticketID").html(TicketID);
		
		$('#something img').attr('src',function(i,e){
			return e.replace("-128x79.jpg","-896x277.jpg");
		})
		
		$("#printButton").html("Print Next Ticket");
		window.print();
	}
	
	
	$('#printDiag').modal({
		show: true,
  		keyboard: false,
		backdrop: 'static'
	})
</script>

</body>
</html>


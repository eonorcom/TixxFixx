<?php
session_start();


$UserID = $_GET["ID"];
if ($UserID == "")
{
	$UserID = $_SESSION['id'];
}

?>

	<div id="header">
    	<div id="header_content">
        	
            <?php if (isset($_SESSION['id'])) { ?>
            	<?php
					$showName = $_SESSION['fullname'];
					if ($showName == "")
					{
						$showName = $_SESSION['username'];
					}
					
					$showLogoutURL = $_SESSION['logout_url'];
					if ($showLogoutURL == "")
					{
						$showLogoutURL = "/logout.php";
					}
				?>
            
	            <div id="loggedin">Signed in as: <?php echo $showName ?>! <a href="<?php echo $showLogoutURL ?>" style="font-size: 11px;">Click here to log out.</a></div>    
                <ul> 
                    <li class="link" onclick="getCart();">View Cart</li>
                    <?php if ($_SESSION['contributor'] == 1) { ?>
                    	<li><a href="/event_set.php">Add Event</a></li>
                    <?php } ?>
                    <li><a href="/profile/">My account</a></li>
                    <li><a href="/">Home</a></li>         
                </ul>
            <?php } else { ?>
                <ul> 
                    <li class="link" onclick="ShowLogin();">Sign in</li>
                    <li><a href="/">Home</a></li>         
                </ul>
            <?php } ?>
        
        </div>
    </div>
    
    <div id="pop_event_form" class="pop_container" style="display: none;">
        <div id="pop" style="width: 630px">
        	<img width="30" height="30" src="/images/close.png" id="close-x" style="position:relative; z-index: 2000; margin: -10px; float:right; cursor: pointer;">
            <table cellpadding="0" cellspacing="0" style="width: 630px;">
            <tr>
                <td><div class="pop_top_left"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td><div class="pop_top_border"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td><div class="pop_top_right"><img src="/images/spacer.png" width="10" height="10" /></div></td>
            </tr>
            <tr>
                <td class="pop_border_side"><img src="/images/spacer.png" width="10" height="10" /></td>
                <td class="pop_content" style="padding: 0px;">
                
                	
                    <div id="event-add-search">
                    	<input type="hidden" id="event-add-id" value="" />
                    
                    	<div style="margin: 0; background: #000; color: #fff; padding: 13px;">
                    		
                            <div id="event-add-helper">
                                Use the serach above to search for an event.   
                            </div>
                            
                            <div id="event-add-ticket-options" style="display: none; float: right; margin-top: -21px; width: 285px;">
                                <label class="checkbox" style="float: left; margin: 0px 10px 0px 0px;">
                               		<input type="checkbox" id="ticket-category-general" value="general" checked="checked" /> General Admission
                                </label>
                                <label class="checkbox" style="float: left;">
                               		<input type="checkbox" id="ticket-category-allocated" value="allocated" /> Allocated Seating
                                </label>
                                
                            </div>    
                    	</div>
                                         
                        
                        
                        <div id="event-add-tickets" style="height: 365px; overflow:auto; padding: 20px; background: #dbdce0; display:none">
                            
                            
                            <table id="ticket-info-general" style="">     
                            <tr>
                            	<td colspan="2">Desciption:</td>
                            </tr>                       
                            <tr>
                            	<td colspan="2"><input type="text" id="ticket-general-desc" style="width: 540px;" /></td>
                            </tr>                        
                            <tr>
                            	<td colspan="2" class="small" style="padding: 0px 0 5px 0;">Example: Floor, General Seating, VIP Section</td>
                            </tr>                       
                            <tr>
                            	<td>Qty:</td>
                            	<td style="padding: 0px 0px 0px 98px;">Price per Ticket</td>
                            </tr>
                            <tr>
                            	<td><input type="text" id="ticket-general-qty" style="width: 200px;" /></td>
                            	<td style="padding: 0px 0px 0px 98px;">
                                <div class="input-prepend">
	                                <span class="add-on">$</span>
    	                        	<input type="text" id="ticket-general-price" style="width: 192px;" />
                                </div>
                                
                                </td>
                            </tr>   
                            <tr>
                            	<td colspan="2">
                                
                                <table style="margin: 5px 0 5px 0;">
                                <tr>
                                    <td width="1" valign="top"><input type="checkbox" id="ticket-general-splits" value="splits" checked="checked" /></td>
                                    <td style="padding: 0px 0px 0px 10px;">
                                    	Allow tickets to be sold in different quantities.
                                    	<div class="small" style="width: 400px;">By checking this box you allow people to buy any number of tickets they would like from you.  If you don't want to split up your tickets . . . don't check this box.</div>    
                                        
                                    </td>
                                </tr>
                                </table>
                                
                                </td>
                            </tr>  
                            <tr>
                            	<td colspan="2">Addition Information:</td>
                            </tr>                       
                            <tr>
                            	<td colspan="2"><textarea id="ticket-general-info" style="width: 540px;"></textarea></td>
                            </tr>        
                            </table>
                                
                                
                            
                            <table id="ticket-info-allocated" style="display: none;">
                            <tr>
                            	<td>Section:</td>
                            	<td>Row:</td>
                            	<td>Seat(s):</td>
                            	<td>Price:</td>
                            </tr>
                            <tr>
                            	<td><input type="text" id="ticket-allocated-section" style="width: 100px;" /></td>
                            	<td><input type="text" id="ticket-allocated-row" style="width: 100px;" /></td>
                            	<td><input type="text" id="ticket-allocated-seats" style="width: 100px;" /></td>
                            	<td><input type="text" id="ticket-allocated-price" style="width: 100px;" /></td>
                            </tr>                           
                            <tr>
                            	<td></td>
                            	<td></td>
                            	<td></td>
                            	<td class="small" style="padding: 0px 0 10px 0;">Specify price per ticket</td>
                            </tr>   
                            <tr>
                            	<td colspan="4">
                                
                                <table style="margin: 0 0 5px 0;">
                                <tr>
                                    <td width="1" valign="top"><input type="checkbox" id="ticket-allocated-splits" value="splits" checked="checked" /></td>
                                    <td style="padding: 0px 0px 0px 10px;">
                                    	Allow tickets to be sold in different quantities.
                                    	<div class="small">By checking this box you allow people to buy any number of tickets they would like from you.  If you don't want to split up your tickets . . . don't check this box.</div>    
                                        
                                    </td>
                                </tr>
                                </table>
                                
                                </td>
                            </tr>  
                            <tr>
                            	<td colspan="4" style="padding: 10px 0 0 0;">Addition Information:</td>
                            </tr>                  
                            <tr>
                            	<td colspan="4"><textarea id="ticket-allocated-info" style="width: 510px;"></textarea></td>
                            </tr>       
                            </table>
                            
                            <div style="text-align: center; padding: 10px 0 0 0;">
                                <input type="button" id="ticket-add" class="btn" value="Add Tickets" />
                            </div>
                            
                        </div>    
                                        
                        <div id="event-add-review" style="height: 365px; overflow:auto; padding: 20px; background: #dbdce0; display:none">
                            
                            <table id="ticket-review-table" style="margin: 0 0 10px 0;" class="table">
                            <tr>
                                <th class="grey small" style="text-align: left; color: #fff; padding: 3px; font-weight:normal">Tickets Information</th>
                                <th class="grey small" style="text-align: center; color: #fff; padding: 3px; font-weight:normal">Qty</th>
                                <th class="grey small" style="text-align: center; color: #fff; padding: 3px; font-weight:normal">Price</th>
                                <th class="grey" style="width: 10px;"></th>
                            </tr>
                            </table>
                            
                            
							<h3>Delivery Options <small>select only one</small></h3>
                            <table style="margin: 5px 0 5px 0;">
                            <tr>
                                <td width="1" valign="top"><input type="checkbox" id="ticket-delivery-eTixx" value="true" checked="checked" onclick="ticketDelivery(this);" /></td>
                                <td style="padding: 0px 0px 0px 10px;">
                                    eTickets by TixxFixx
                                    <div class="small">Select this option and we will generate an eTicket for the purchaser to download and bring to your event.  We will also create and will call sheet for you so you can cross check all tickets as they come to your event.</div>    
                                    
                                </td>
                            </tr>
                            <tr style="display: none">
                                <td width="1" valign="top"><input type="checkbox" id="ticket-delivery-fedex" value="true" checked="checked" onclick="ticketDelivery(this);" /></td>
                                <td style="padding: 0px 0px 0px 10px;">
                                    Fed Ex
                                    <div class="small">Select this option if you are planning on shipping the tickets to the purchaser via Fed Ex.  Shipping cost will be calculated at the time of checkout and you will be able to print a Fed Ex shipping label right from the system.</div>    
                                    
                                </td>
                            </tr>
                            <tr>
                            	<td><br /></td>
                            </tr>
                            <tr>
                                <td width="1" valign="top"><input type="checkbox" id="ticket-delivery-willcall" value="true" onclick="ticketDelivery(this);" /></td>
                                <td style="padding: 0px 0px 0px 10px;">
                                    Will Call
                                    <div class="small">Select this option if you are going to leave the tickets at Will Call or create a Will Call List of everyone who purchased tickets from TixxFixx.</div>    
                                    
                                </td>
                            </tr>
                            <tr>
                            	<td><br /></td>
                            </tr>
                            <tr>
                                <td width="1" valign="top"><input type="checkbox" id="ticket-delivery-contact" value="true" onclick="ticketDelivery(this);" /></td>
                                <td style="padding: 0px 0px 0px 10px;">
                                    Make Your Own Arragments
                                    <div class="small">By selecting this option you will be put in contact with the purcheser to make your own arrangments on how to deliver the tickets to them.</div>    
                                    
                                </td>
                            </tr>
                            </table>
                            
                            
                            <div style="text-align: center; padding: 10px 0 0 0;">
                            	<input type="button" id="ticket-add-more" class="btn" value="Add More Tickets" />
                            	<input type="button" id="ticket-add-save" class="btn" value="Save Tickets" />
                            </div>
                            
                        </div>
                        
                        <div id="#event-add-complete" style="height: 300px; overflow:auto; padding: 15px; background: #dbdce0; display:none">
                        	You just added some tickets.  You can track your tickets in the "My Tickets" section of the site. 
                        </div>
                    
                    </div>
                                     
                </td>
                <td class="pop_border_side"><img src="/images/spacer.png" width="10" height="10" /></td>
            </tr>
            <tr>
                <td valign="top"><div class="pop_bottom_left"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td valign="top"><div class="pop_bottom_border"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td valign="top"><div class="pop_bottom_right"><img src="/images/spacer.png" width="10" height="10" /></div></td>
            </tr>
            </table>
        </div>
    </div>
    
    
    
    <div id="pop_flag" class="pop_container" style="display: none;">
        <div id="pop">
        	<img width="30" height="30" src="/images/close.png" class="close-flagged" style="position:relative; z-index: 2000; margin: -10px; float:right; cursor: pointer;">
            <table cellpadding="0" cellspacing="0" style="width: 572px;">
            <tr>
                <td><div class="pop_top_left"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td><div class="pop_top_border"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td><div class="pop_top_right"><img src="/images/spacer.png" width="10" height="10" /></div></td>
            </tr>
            <tr>
                <td class="pop_border_side"><img src="/images/spacer.png" width="10" height="10" /></td>
                <td class="pop_content" style="padding: 0px;">
                
                	
                    <div id="flagging-a-song">
                        <div id="pop_flag_id" class="hidden"></div>
                    
                    	<div id="flagging-a-song-actions" style="margin: 0; background: #000; color: #fff; padding: 13px; height: 55px;">
                    		<div style="width: 500px; height: 41px;">
	                            Update Image: <span id="flag-song-title"></span>
                            </div>
                            
                            <div id="event-add-ticket-options" style="float: right; margin-top: 0px; width: 500px;">
                                <table>
                                <tr>
                                    <td width="1"><input type="checkbox" id="image-type-event" name="image-type" value="event" onclick="changeImage('','event');" checked="checked" /></td>
                                    <td style="padding: 0px 0px 0px 10px;" class="small white"><label for="image-type-event" style="margin-bottom: -2px;">By Event</label></td>
                                    <td width="1"><input type="checkbox" id="image-type-venue" name="image-type" value="venue" onclick="changeImage('','venue');" /></td>
                                    <td style="padding: 0px 0px 0px 10px;" class="small white"><label for="image-type-venue" style="margin-bottom: -2px;">For Venue</label></td>
                                    <td width="1"><input type="checkbox" id="image-type-search" name="image-type" value="url" onclick="changeImage('','search');" /></td>
                                    <td style="padding: 0px 0px 0px 10px;" class="small white"><label for="image-type-search" style="margin-bottom: -2px;">Search</label></td>
                                    <td width="1"><input type="checkbox" id="image-type-url" name="image-type" value="url" onclick="changeImage('','url');" /></td>
                                    <td style="padding: 0px 0px 0px 10px;" class="small white"><label for="image-type-url" style="margin-bottom: -2px;">From URL</label></td>
                                    <td width="1"><input type="checkbox" id="image-type-upload" name="image-type" value="file" onclick="changeImage('','upload');" /></td>
                                    <td style="padding: 0px 0px 0px 10px;" class="small white"><label for="image-type-upload" style="margin-bottom: -2px;">Upload File</label></td>
                                </tr>
                                </table>
                            </div>    
                            
                    	</div>
                        
                        <div id="flagging-a-song-actions" style="height: 300px; overflow:auto; font-size: 11px;">
                                
                            	<div id="flag-update-image">
                                
                                    <div id="image-type-url-box" style="display: none; background: #dbdce0; padding: 13px;">
	                                	URL: <input type="text" id="image-type-url-search" value="" style="width: 381px;" /> <input type="submit" value="Get Images" onclick="changeImageScrapper();" />
                                    </div>
                                
                                    <div id="image-type-search-box" style="display: none; background: #dbdce0; padding: 13px;">
	                                	SEARCH: <input type="text" id="image-type-search-search" value="" style="width: 359px;" /> <input type="submit" value="Get Images" onclick="changeImage('','search');" />
                                    </div>
                                
                                    <div id="image-type-upload-box" style="display: none; background: #dbdce0; padding: 13px; font-size: 13px;">
	                                	<form action="/Classes/images.upload.ajax.php" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
                                        Feature Image:<br />
                        					<input type="hidden" id="Flag-EventID" name="id" value="" />
                                            <input type="hidden" name="maxSize" value="9999999999" />
                                            <input type="hidden" name="maxW" value="592" />
                                            <input type="hidden" name="returnW" value="300" />
                                            <input type="hidden" name="fullPath" value="/Classes/images/cache" />
                                            <input type="hidden" name="relPath" value="images/" />
                                            <input type="hidden" name="colorR" value="255" />
                                            <input type="hidden" name="colorG" value="255" />
                                            <input type="hidden" name="colorB" value="255" />
                                            <input type="hidden" name="maxH" value="314" />
                                            <input type="hidden" name="filename" value="filename" />
                                            <input type="file" name="filename" size="60" onchange="ajaxUpload(this.form,'/Classes/images.upload.ajax.php?filename=name&amp;maxSize=9999999999&amp;maxW=116&amp;fullPath=&amp;relPath=images/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=300','upload_area','File Uploading Please Wait...','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" />
                                        </form>
                                    </div>
                                  
                                  	
                                    <div id="flag_new_images" style="text-align: left; padding: 13px;">
                                    </div>
									<div id="upload_area" style="margin: 10px 0 0 0; padding: 13px;"></div>
                                            
                                </div>
                            </div>
                        </div>
                    
                    </div>
                        
                </td>
                <td class="pop_border_side"><img src="/images/spacer.png" width="10" height="10" /></td>
            </tr>
            <tr>
                <td valign="top"><div class="pop_bottom_left"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td valign="top"><div class="pop_bottom_border"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td valign="top"><div class="pop_bottom_right"><img src="/images/spacer.png" width="10" height="10" /></div></td>
            </tr>
            </table>
        </div>
    </div>
    
    <div id="pop_feature" class="pop_container" style="display: none;">
        <div id="pop">
        	<img width="30" height="30" src="/images/close.png" onclick="$('#pop_feature').hide();" style="position:relative; z-index: 2000; margin: -10px; float:right; cursor: pointer;">
            <table cellpadding="0" cellspacing="0" style="width: 572px;">
            <tr>
                <td><div class="pop_top_left"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td><div class="pop_top_border"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td><div class="pop_top_right"><img src="/images/spacer.png" width="10" height="10" /></div></td>
            </tr>
            <tr>
                <td class="pop_border_side"><img src="/images/spacer.png" width="10" height="10" /></td>
                <td class="pop_content" style="padding: 0px;">
                
                	
                    <div id="flagging-a-song">
                        <div id="pop_flag_id" class="hidden"></div>
                    
                    	<div id="flagging-a-song-actions" style="margin: 0; background: #000; color: #fff; padding: 13px;">
	              		    Feature Option
                    	</div>
                        
                        <div id="flagging-a-song-actions" style="overflow:auto; font-size: 13px; padding:30px;">
                        
                        	How would you like to feature this event?
                            
                            <br />
                            <br />    
                            
                            <div class="well" style="text-align:center">
                            <button class="btn btn-danger" onclick="featureEventSend(2);">Feature on the Home page</button>  
                            <button class="btn btn-inverse" onclick="featureEventSend(1);">Only in the Category Section</button>    
                            </div>
                        </div>
                    
                    </div>
                        
                </td>
                <td class="pop_border_side"><img src="/images/spacer.png" width="10" height="10" /></td>
            </tr>
            <tr>
                <td valign="top"><div class="pop_bottom_left"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td valign="top"><div class="pop_bottom_border"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td valign="top"><div class="pop_bottom_right"><img src="/images/spacer.png" width="10" height="10" /></div></td>
            </tr>
            </table>
        </div>
    </div>
    
    <div id="pop_login" class="pop_container" style="display: none;">
        <div id="pop">
        	<img width="30" height="30" src="/images/close.png" id="close-login" style="position:relative; z-index: 2000; margin: -10px; float:right; cursor: pointer;">
            <table cellpadding="0" cellspacing="0" style="width: 572px;">
            <tr>
                <td><div class="pop_top_left"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td><div class="pop_top_border"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td><div class="pop_top_right"><img src="/images/spacer.png" width="10" height="10" /></div></td>
            </tr>
            <tr>
                <td class="pop_border_side"><img src="/images/spacer.png" width="10" height="10" /></td>
                <td class="pop_content" style="padding: 0px;">
                
                	
                    <div id="login-agree">
                    	<div style="margin: 0; background: #000; color: #fff; padding: 13px;">
                    		Sign in to the TixxFixx.com with Facebook and Twitter
                    	</div>
                        
                        <div style="padding: 15px; font-size: 12px;">
                                      
                            <p>We've made it easy for you to sign into TixxFixx.com with the ability to use your Facebook and Twitter credentials. Here's why:</p>
                            
                            <ul>
                            	<li>It provides a simple one click access to all tickets and events on TixxFixx.com</li>
                            	<li>It means that you don't have to keep track of another username and password</li>
                            	<li>No long sign-up forms to fill out</li>
                            	<li>This is really the quickest, fastest way to get you what you want</li>
                           	</ul>
                            
                            <p>We hope you agree.  Please let us know if you have any questions.</p>
                            
                            
                            <div id="agree" style="text-align: center; margin: 20px;">
                                <img src="/images/agree.png" class="link" onclick="agree();">
                            </div>
                            
                            
                            <div id="login_buttons" style="text-align: center; margin: 20px; display: none;">
                                <a href="/login.php?login&oauth_provider=twitter"><img src="/images/tw_login.png"></a>&nbsp;&nbsp;&nbsp;
                                <a href="/login.php?login&oauth_provider=facebook"><img src="/images/fb_login.png"></a>
                            </div>
                                    
                                        
                        </div>
                    
                    </div>
                    
                        
                </td>
                <td class="pop_border_side"><img src="/images/spacer.png" width="10" height="10" /></td>
            </tr>
            <tr>
                <td valign="top"><div class="pop_bottom_left"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td valign="top"><div class="pop_bottom_border"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td valign="top"><div class="pop_bottom_right"><img src="/images/spacer.png" width="10" height="10" /></div></td>
            </tr>
            </table>
        </div>
    </div>
    
    <div id="cart-template" style="display: none;">
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
                
                <div class="info-box">
                	
                    <div>
                	<h2>%EventTitle% @ %VenueName%</h2>
                    <h3>%City%, %State%&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;%StartDateFormated%&nbsp;&nbsp;%StartTimeFormated%</h3>
                    </div>
                    <div style="width: 220px; float: left;">
                        <b>%TicketDesc%</b>
                    </div>
                    <div style="width: 50px; float: left;">
                        <b>Qty: </b>%Qty%
                    </div>
                    <div style="width: 90px; float: left;">
                        <b>Price: </b> <div style="float: right; widht: 50px; padding-right: 10px;">%Price%</div>
                    </div>
                    <div style="width: 90px; float: left;">
                        <b>SubTotal: </b> <div style="float: right; widht: 50px;">%SubTotal%</div>
                    </div>
                    <div class="controls">
                        <li class="no-border" onclick="deleteFromCart(%CartID%, 'cart');" style="color: #BD1E2D;"><img src="/images/icon_delete.png" height="10" /></li>
                        
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
    
    <div id="pop_cart" class="pop_container" style="display: none;">
        <div id="pop">
        	<img width="30" height="30" src="/images/close.png" onclick="$('#pop_cart').hide();" style="position:relative; z-index: 2000; margin: -10px; float:right; cursor: pointer;">
            <table cellpadding="0" cellspacing="0" style="width: 572px;">
            <tr>
                <td><div class="pop_top_left"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td><div class="pop_top_border"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td><div class="pop_top_right"><img src="/images/spacer.png" width="10" height="10" /></div></td>
            </tr>
            <tr>
                <td class="pop_border_side"><img src="/images/spacer.png" width="10" height="10" /></td>
                <td class="pop_content" style="padding: 0px;">
                
                    	<div style="margin: 0; background: #000; color: #fff; padding: 13px;">
                    		Your Cart
                    	</div>
                        
                        <div style="padding: 15px; font-size: 11px;" id="cart-tickets-list">
                                      
                                        
                        </div>
                        
                        <div style="padding: 15px;">
                    		<input type="button" value="Find More Tickets" class="btn pull-left" onclick="$('#pop_cart').hide();"  />
                    		<input id="cart_continue_button" type="button" value="Continue to Checkout" class="btn pull-right" onclick="gotoCheckout();" />
    					</div>
                        
                        <br style="clear: both" />
                    
                        
                </td>
                <td class="pop_border_side"><img src="/images/spacer.png" width="10" height="10" /></td>
            </tr>
            <tr>
                <td valign="top"><div class="pop_bottom_left"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td valign="top"><div class="pop_bottom_border"><img src="/images/spacer.png" width="10" height="10" /></div></td>
                <td valign="top"><div class="pop_bottom_right"><img src="/images/spacer.png" width="10" height="10" /></div></td>
            </tr>
            </table>
        </div>
    </div>
    
    
	<SCRIPT language="JavaScript">
    <!--
    if (document.images)
    {
      player_loader = new Image(16,16); 
      player_loader.src="/images/player_loader.gif"; 
    }
    //-->
    </SCRIPT>
  

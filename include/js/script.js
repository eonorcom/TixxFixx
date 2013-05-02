var json = "";
var addTickets = "";
var total_items = 1;
var page_number = 1;
var page_size = 1;
var page_count = 1;
var event_category = "";
/* Static Page Functions */


$(document).ready(function()
{
	$("#search-box").keyup(function(event){
		if(event.keyCode == 13){
			$("#search-button").click();
		}
	});
	
	
	$("#ticket-category-general").live("click", function()
	{
		$("#ticket-category-general").attr('checked', true);
		$("#ticket-category-allocated").attr('checked', false);
				
		$("#ticket-info-general").show();
		$("#ticket-info-allocated").hide();
	});
	
	$("#ticket-category-allocated").live("click", function()
	{
		$("#ticket-category-allocated").attr('checked', true);
		$("#ticket-category-general").attr('checked', false);
		
		$("#ticket-info-general").hide();
		$("#ticket-info-allocated").show();
	});
	
	$("#search-to-add").live("click", function()
	{	
		$("#event-add-results").html("<div style='text-align: center; padding: 125px 0;'><img src='/images/wheel_throbber.gif'></div>");	
		$.getJSON('/Classes/eventful.list.php',{
				s: $("#search-for-event").val()				
			},
			function(data) {
				searchToAdd(data);
			}
		);
		return false;
	});
		
	$(".close-flagged").live("click", function()
	{	
		$('.checkbox').prop("checked", false);
		$("#pop_flag").hide();
		return false;
	});
	
	
	$("#ticket-add").live("click", function()
	{
		eventTicketAdd();
	});
	
	$("#ticket-add-more").live("click", function()
	{
		getTickets();
	});
	
	$("#ticket-add-save").live("click", function()
	{
		saveTickets();
	});
	
	$("#close").live("click", function()
	{	
		$("#pop_event_form").hide();
		return false;
	});
	
	$("#close-x").live("click", function()
	{	
		$("#pop_event_form").hide();
		return false;
	});
	
	$("#close-login").live("click", function()
	{	
		$("#pop_login").hide();
		return false;
	});
	
	$("#close-cart").live("click", function()
	{	
		$("#pop_cart").hide();
		return false;
	});
	
	$("img.icon").live("click", function() 
	{
		if (SESSION.id == "")
		{
			ShowLogin();
			return false;
		}
		
		var arrayThis = $(this).attr('id').split("-");
		var Action = arrayThis[0];
		var ID = arrayThis[1] + "-" + arrayThis[2] + "-" + arrayThis[3] + "-" + arrayThis[4];
		 
		if (Action == "like")
		{
			if ($.cookie("type") == "suggestions")
			{
				approveSuggestion(ID);
			}
			else
			{
				setLike(ID);
			}
		}
		
		if (Action == "hate")
		{
			setHate(ID);
		}
		
		if (Action == "mylist")
		{
			setMyList(ID);
		}
		
		if (Action == "flag")
		{
			setFlag(ID);
		}
		
		if (Action == "image")
		{
			getThumb(ID);
		}
		
		if (Action == "add")
		{
			addSelectedEvent(ID);
			return false;
		}
	});
});

function initSite(c, id, d)
{
	if (id != "")
	{
		getEventDetails(id)
	}
	else
	{
		getEvents(c, d);	
		getFeatured(c, d);	
	}
}

function getEventDetails(id)
{
	resetPage();
	$("#section-selector").show();
	$("#event-selector").show();
	$("#event-header").show();
	$("#event").show();
	
	$.getJSON("/Classes/event.get.php",
	{
		ID: id
	},
		function(data) {
			eventDetails(data)
	});	
	//getEventTickets(id);
}

function eventDetails(data)
{
	var v = $.cookie("value");
	var t = $.cookie("type");	
		
	json = data;	
		
	var id = json.id;
	var url = json.url;
	var title = json.title;
	var description = json.description;
	var start_time = json.start_time;
	var venue_name = json.venue_name;
	var venue_id = json.venue_id;
	var address = json.address;
	var city = json.city;
	var region = json.region;
	var region_abbr = json.region_abbr;
	var postal_code = json.postal_code;
	var latitude = json.latitude;
	var longitude = json.longitude;
	var free = json.free;
	var price = json.price;
	var withdrawn = json.withdrawn;
	var withdrawn_note = json.withdrawn_note;
	
	
	var eventImage = ""
	
	if (json.images)
	{
		eventImage = '<img width="120" style="padding: 0 0 0 10px;" class="event_image" src="/Classes/images.cache.php?id=' + id + '&url=' + json.images.image[0].medium.url.replace(/medium/g, "block250") + '" />';
	}
	else
	{
		eventImage = '<img width="120" style="padding: 0 0 0 10px;" class="event_image" src="/Classes/images.cache.php?id=' + id + '" />';
	}
	
	
	$("#Event-Title-Img").html(eventImage);
	$("#Event-Title-EventName").html(title);
	$("#Event-Title-StartTime").html($.format.date(start_time, "M/d/yyyy"));
	$("#Event-Title-VenueName").html(venue_name);
	
	
	
	$("#Event-Details-Title").html(title.toUpperCase() + " AT " + venue_name.toUpperCase());
	$("#Event-Details-Text").html(description.replace(/\n/g, "<br>"));
	
	if (price != "")
	{
		$("#Event-Details-Price").html("Price: " + price);
	}
	
	var links = "<b>LINKS:</b> ";
	
	for (count = 0; count < json.links.link.length; count++)
	{	
		var link_url = json.links.link[count].url;
		var link_type = json.links.link[count].type;
		var link_description = json.links.link[count].description;
		
		links += '<a href="' + link_url + '" target="_blank" title="' + link_description + '">' + link_type + '</a> | ';
	}	
	
	links += '**';
	
	$("#Event-Details-Links").html(links.replace(" | **", ""));
	
	//API Key: 681570708309d5d13ae7f8ba1fb508c90
	var shareTitle = "Find Tickets to " + toTitleCase(title) + " at " + toTitleCase(venue_name) + " on TixxFixx.com!";
	var shareLink = 'http://www.tixxfixx.com' + cleanURL(url);
	var shareImage = 'http://www.tixxfixx.com' + eventImage;
	
	$('title').text(shareTitle);
	$("meta[property=og\\:title]").attr("content", shareTitle);
	$("meta[property=og\\:description]").attr("content", "Buy, Sale, Trade all your tickets only at TixxFixx.com");
	$("meta[property=og\\:url]").attr("content", shareLink);
	$("meta[property=og\\:image]").attr("content", shareImage);

	var shareFacebook = '<img src="/images/icon_facebook.png" width="29" height="29" title="Share on Facebook" class="link" onclick="window.open(\'http://www.facebook.com/sharer.php?u=' + encodeURIComponent(shareLink) + '&t=' + encodeURIComponent(shareTitle) + '\');" />';
	var shareTwitter = '<img src="/images/icon_twitter.png" width="29" height="29" title="Tweet This" class="link" onclick="window.open(\'http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=681570708309d5d13ae7f8ba1fb508c90&service=7&title=' + shareTitle + '&link=' + shareLink + '&template=' + shareTitle + '\');" />';
	var sharePintrest = '<img src="/images/icon_pintrest.png" width="29" height="29" title="Pin It" class="link" onclick="window.open(\'http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(shareLink) + '&media=' + encodeURIComponent(shareImage) + '&description=' + shareTitle + '\');" />';
	var shareBlog = '<img src="/images/icon_blog.png" width="29" height="29" title="Post to Blogger" class="link" onclick="window.open(\'http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=681570708309d5d13ae7f8ba1fb508c90&service=219&title=' + shareTitle + '&link=' + shareLink + '&template=' + shareTitle + '\');" />';
	var shareGoogle = '<img src="/images/icon_google.png" width="29" height="29" title="Google+" class="link" onclick="window.open(\'http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=681570708309d5d13ae7f8ba1fb508c90&service=304&title=' + shareTitle + '&link=' + shareLink + '&template=' + shareTitle + '\');" />';
	var sharePeramLink = '<img src="/images/icon_link.png" width="29" height="29" title="Direct Link" class="link" onclick="window.open(\'' + shareLink + '\');" />';
	
	var shareText = shareFacebook + shareTwitter + sharePintrest + shareBlog + shareGoogle + sharePeramLink;
	
	$("#event-share").html(shareText);
	
	$("#event-comments").html('<div class="fb-comments" data-href="' + shareLink + '" data-num-posts="10" data-width="542"></div>');
	FB.XFBML.parse();
	
}


function getEventTickets(id)
{
	
	$.getJSON("/Classes/event.tickets.get.php",
	{
		ID: id
	},
		function(data) {
			//eventTickets(data)
	});	
}


function eventTickets(data)
{		
	var template = $("#event-tickets-template").html();	
	
	var outHtml = "";
	
	json = data;	
	var dataLength = json.tickets.length;
	
	for (count = 0; count < dataLength; count++)
	{	
		var code = template;
	
		var TicketID = json.tickets[count].id;
		var EventID = json.tickets[count].EventID;
		var TicketType = json.tickets[count].TicketType;
		var TicketDesc = json.tickets[count].TicketDesc;
		var Section = json.tickets[count].Section;
		var Row = json.tickets[count].Row;
		var Seats = json.tickets[count].Seats;
		var Qty = json.tickets[count].Qty;
		var Price = json.tickets[count].Price;
		var Splits = json.tickets[count].Splits;
		var AdditionalInfo = json.tickets[count].AdditionalInfo;
		var FeddEx = json.tickets[count].FeddEx;
		var WillCall = json.tickets[count].WillCall;
		var Contact = json.tickets[count].Contact;
		var AddedOn = json.tickets[count].AddedOn;
		var username = json.tickets[count].username;
		var fullname = json.tickets[count].fullname;
		
		code = code.replace(/%Cnt%/g, count + 1);
		code = code.replace(/%TicketID%/g, TicketID);
		code = code.replace(/%EventID%/g, EventID);
		code = code.replace(/%TicketType%/g, TicketType);
		code = code.replace(/%TicketDesc%/g, TicketDesc);
		code = code.replace(/%Section%/g, Section);
		code = code.replace(/%Row%/g, Row);
		code = code.replace(/%Seats%/g, Seats);
		code = code.replace(/%Price%/g, Price);
		code = code.replace(/%Splits%/g, Splits);
		code = code.replace(/%AdditionalInfo%/g, AdditionalInfo);
		code = code.replace(/%FeddEx%/g, FeddEx);
		code = code.replace(/%WillCall%/g, WillCall);
		code = code.replace(/%Contact%/g, Contact);
		code = code.replace(/%AddedOn%/g, $.format.date(AddedOn, "M/d/yyyy"));
		code = code.replace(/%username%/g, username);
		code = code.replace(/%fullname%/g, fullname);
		
		if (Qty == "0")
		{
			code = code.replace(/%ShowAddToCart%/g, "display: none;");	
			code = code.replace(/%ShowSoldOut%/g, "");	
		}
		else
		{
			code = code.replace(/%ShowAddToCart%/g, "");
			code = code.replace(/%ShowSoldOut%/g, "display: none;");
		}
		
		
		if (Splits == "true")
		{
			if (Qty > 1)
			{	
				var qtyList = '<select name="Ticket-Qty-Select-' + TicketID + '" id="Ticket-Qty-Select-' + TicketID + '" Enabled="true">';
				for (var i = 1; i <= Qty; i++) {
					qtyList += '<option value="' + i + '" onclick="selectThis(' + TicketID + ', ' + (i - 1) + ');">' + i + '</option>';
				}
				qtyList += "</select>";
				
				Qty = qtyList;
				
				code = code.replace(/%Qty%/g, Qty);
			}
			else
			{
				//Qty = '<input name="Ticket-Qty-Select-' + TicketID + '" id="Ticket-Qty-Select-' + TicketID + '" value="' + Qty + '" class="span2" id="prependedInput" type="text">';
				code = code.replace(/%Qty%/g, Qty);
			}
		}
		else
		{
			//Qty = '<input name="Ticket-Qty-Select-' + TicketID + '" id="Ticket-Qty-Select-' + TicketID + '" value="' + Qty + '" class="span2" id="prependedInput" type="text">';
			code = code.replace(/%Qty%/g, Qty);
		}
		
		if (Row == "null" || Row == "")
		{
			code = code.replace(/%ShowRowSeat%/g, "display: none;");
		}
		else
		{
			code = code.replace(/%ShowRowSeat%/g, "");		
		}
		outHtml += code;
	}
	$("#event-tickets-list").html(outHtml);	
}

function searchEvents()
{
	var s = $("#search-box").val();
	
	$("#events").html("<div style='text-align: center; margin-top: 30px;'><img src='/images/wheel_throbber.gif'></div>");	
	resetPage();
	$("#section-selector").show();
	$("#event-selector").show();
	$("#events-list").show();
	
	$("#section-header").show();
	$("#events").show();
	$("#events").attr("style", "");
	
	$("#section-title").html("Search Results");	
	$("#section-desc").html("Yep that is what you searched for!");	
	
	$.getJSON("/Classes/event.search.php",
	{
		s: s,
		page: page_number,
		c: event_category
	},
		function(data) {
			listEvents(data)
	});	
}

function getEvents(type, date)
{ 
	var userid = "";
	var value  = "";
	event_category = type;
	if (userid == 1)
	{
		userid = $("#profile-ID").html();
	}
	
	if (value < 0)
	{
		value = 1;	
	}
	
	try 
	{
		$.cookie("value", value);
		$.cookie("type", type);
	}
	catch(err) {}
	
	$("#events").html("<div style='text-align: center; margin-top: 30px;'><img src='/images/wheel_throbber.gif'></div>");	
	
	resetPage();
	$("#section-selector").show();
	$("#event-selector").show();
	$("#events-list").show();
	
	$("#section-header").show();
	$("#events").show();
	$("#events").attr("style", "");
	
	$("#section-title").html(sectionTitle[value]);	
	$("#section-desc").html(sectionDesc[value]);	
	
	$.getJSON("/Classes/event.list.php",
	{
		page: page_number,
		c: type,
		d: date
	},
		function(data) {
			listEvents(data)
	});	
}

function listEvents(data)
{	
	try
	{
		var v = $.cookie("value");
		var t = $.cookie("type");	
	}
	catch(err)
	{
		
	}
		
	json = data;	
	
	var template = $("#event-template").html();	
	
	var outHtml = "";
	
	var dataLength = json.events.event.length;
	
	if (json.total_items == 1)
	{
		dataLength = 1;
	}
	
		
	total_items = json.total_items;
	page_number = json.page_number;
	page_size = json.page_size;
	page_count = json.page_count;
	
	
	for (count = 0; count < dataLength; count++)
	{	
		var code = template;			
		var useAlbum = 1;
		
		//json.events.event[1].performers.performer
		//json.events.event[1].image.thumb.url
		if (dataLength == 1)
		{			
			var EventID = json.events.event.id;
			
			if (EventID.indexOf("@") > 0)
			{
				EventID = EventID.split("@");
				EventID = EventID[0]
			}
			
			var EventTitle = json.events.event.title;
			var EventURL = json.events.event.url;
			var EventDesc = json.events.event.description;
			var StartTime = json.events.event.start_time;
			var StopTime = json.events.event.stop_time;
			var Price = json.events.event.price;
			var Source = json.events.event.owner;
			
			var VenueID = json.events.event.venue_id;
			var VenueName = json.events.event.venue_name;
			var VenueURL = json.events.event.venue_url;
			var Address = json.events.event.venue_address;
			var City = json.events.event.city_name;
			var State = json.events.event.region_abbr;
			var PostalCode = json.events.event.potal_code;
			var Country = json.events.event.country_name;
			var Latitude = json.events.event.latitude;
			var Longitude = json.events.event.longitude;
			
			var PerformerID = "";
			var PerformerName = "";
			var PerformerShortBio = "";
			
			if (json.events.event.performers != "")
			{
				var PerformerID = json.events.event.performers.performer.id;
				var PerformerName = json.events.event.performers.performer.name;
				var PerformerShortBio = json.events.event.performers.performer.short_bio;
			}
			
			if (json.events.event.image != "")
			{
				var EventImage = "/Classes/images.cache.php?id=" + EventID + "&refresh=false&url=" + json.events.event.image.medium.url + "";
			}
			else
			{
				var EventImage = "/Classes/images.cache.php?id=" + EventID + "&refresh=false";
			}
		}
		else
		{
			var EventID = json.events.event[count].id;
			
			if (EventID.indexOf("@") > 0)
			{
				EventID = EventID.split("@");
				EventID = EventID[0]
			}
			
			var EventTitle = json.events.event[count].title;
			var EventURL = cleanURL(json.events.event[count].url);
			var EventDesc = json.events.event[count].description;
			var StartTime = json.events.event[count].start_time;
			var StopTime = json.events.event[count].stop_time;
			var Price = json.events.event[count].price;
			var Source = json.events.event[count].owner;
			
			var VenueID = json.events.event[count].venue_id;
			var VenueName = json.events.event[count].venue_name;
			var VenueURL = cleanURL(json.events.event[count].venue_url);
			var Address = json.events.event[count].venue_address;
			var City = json.events.event[count].city_name;
			var State = json.events.event[count].region_abbr;
			var PostalCode = json.events.event[count].potal_code;
			var Country = json.events.event[count].country_name;
			var Latitude = json.events.event[count].latitude;
			var Longitude = json.events.event[count].longitude;
			
			if (json.events.event[count].performers != "")
			{
				var PerformerID = json.events.event[count].performers.performer.id;
				var PerformerName = json.events.event[count].performers.performer.name;
				var PerformerShortBio = json.events.event[count].performers.performer.short_bio;
			}
			
			if (json.events.event[count].image != "")
			{
				var EventImage = "/Classes/images.cache.php?id=" + EventID + "&refresh=false&url=" + json.events.event[count].image.medium.url + "";
			}
			else
			{
				var EventImage = "/Classes/images.cache.php?id=" + EventID + "&refresh=false";
			}
		}
		
		
		code = code.replace(/%Cnt%/g, count + 1);
		code = code.replace(/%EventID%/g, EventID);
		code = code.replace(/%EventTitle%/g, EventTitle);
		code = code.replace(/%EventURL%/g, EventURL);
		code = code.replace(/%EventDesc%/g, EventDesc);
		code = code.replace(/%EventImage%/g, EventImage);
		
		code = code.replace(/%StartTime%/g, StartTime);
		code = code.replace(/%StartDateFormated%/g, $.format.date(StartTime, "M/d/yyyy"));
		if ($.format.date(StartTime, "h:mm a") == "12:00 AM")
		{
			code = code.replace(/%StartTimeFormated%/g, "");
		}
		else
		{
			code = code.replace(/%StartTimeFormated%/g, $.format.date(StartTime, "h:mm a"));
		}
		code = code.replace(/%Price%/g, Price);
		code = code.replace(/%Source%/g, Source);
		
		code = code.replace(/%VenueID%/g, VenueID);
		code = code.replace(/%VenueName%/g, VenueName);
		code = code.replace(/%VenueURL%/g, VenueURL);
		code = code.replace(/%Address%/g, Address);
		code = code.replace(/%City%/g, City);
		code = code.replace(/%State%/g, State);
		code = code.replace(/%PostalCode%/g, PostalCode);
		code = code.replace(/%Country%/g, Country);
		code = code.replace(/%Latitude%/g, Latitude);
		code = code.replace(/%Longitude%/g, Longitude);
		
		
		code = code.replace(/%event-image%/g, "<img src=\"" + EventImage + "\" class=\"icon\" id=\"EventImageThumb-" + EventID + "\"  width=\"116\" />");
		
		EventID = "";
		EventTitle = "";
		EventURL = "";
		EventDesc = "";
		StartTime = "";
		StopTime = "";
		
		Price = "";
		Source = "";
		
		VenueID = "";
		VenueName = "";
		VenueURL = "";
		Address = "";
		City = "";
		State = "";
		PostalCode = "";
		Country = "";
		Latitude = "";
		Longitude = "";
		
		PerformerID = "";
		PerformerName = "";
		PerformerShortBio = "";
		
		outHtml += code;
	}
	$("#events").html(outHtml);	
}



function getFeatured(type, date)
{ 
	var userid = "";
	var value  = "";
	event_category = type;
	if (userid == 1)
	{
		userid = $("#profile-ID").html();
	}
	
	if (value < 0)
	{
		value = 1;	
	}
	
	$("#featured").html("<div style='text-align: center; margin-top: 30px;'><img src='/images/wheel_throbber.gif'></div>");	
	
	$.getJSON("/Classes/event.featured.php",
	{
		page: page_number,
		c: type,
		d: date
	},
		function(data) {
			listFeatured(data)
	});	
}

function listFeatured(data)
{		
	json = data;	
	
	var template = $("#featured-template").html();	
	
	var outHtml = "";
	
	if (!json.featured)
	{
		$("#featured-list").hide();
		return false
	}
	
	var dataLength = json.featured.length;
	
	if (json.total_items == 1)
	{
		dataLength = 1;
	}
	
	for (count = 0; count < dataLength; count++)
	{	
		var code = template;			
		
		var EventID = json.featured[count].EventID;
		
		var EventTitle = json.featured[count].EventTitle;
		var EventDesc = json.featured[count].EventDesc;
		var EventURL = json.featured[count].EventURL;
		var StartTime = json.featured[count].StartTime;
		
		var VenueID = json.featured[count].VenueID;
		var VenueName = json.featured[count].VenueName;
		var City = json.featured[count].City;
		var State = json.featured[count].State;
		
		var EventImage = "/Classes/images.cache.php?id=" + EventID + "&refresh=false";
		
		code = code.replace(/%Cnt%/g, count + 1);
		code = code.replace(/%EventID%/g, EventID);
		code = code.replace(/%EventTitle%/g, EventTitle);
		code = code.replace(/%EventURL%/g, EventURL);
		code = code.replace(/%EventImage%/g, EventImage);
		
		
		code = code.replace(/%StartTime%/g, StartTime);
		code = code.replace(/%StartDateFormated%/g, $.format.date(StartTime, "M/d/yyyy"));
		if ($.format.date(StartTime, "h:mm a") == "12:00 AM")
		{
			code = code.replace(/%StartTimeFormated%/g, "");
		}
		else
		{
			code = code.replace(/%StartTimeFormated%/g, $.format.date(StartTime, "h:mm a"));
		}
		
		code = code.replace(/%VenueID%/g, VenueID);
		code = code.replace(/%VenueName%/g, VenueName);
		code = code.replace(/%City%/g, City);
		code = code.replace(/%State%/g, State);
		
		code = code.replace(/%event-image%/g, "<img src=\"" + EventImage + "\" class=\"icon\" id=\"EventImageThumb-" + EventID + "\"  width=\"116\" />");
		
		outHtml += code;
	}
	$("#featured").html(outHtml);	
	$("#featured-list").show();
}

function deleteEvent(ID)
{
	
	$.ajax({
        url: '/Classes/event.delete.php',
        type: 'POST',
		data: { EventID: ID },
        async: false,
        cache: false,
        timeout: 30000,
        error: function(){
            return true;
        },
        success: function(msg){ 
			refreshLibrary();
            return true;
        }
    });
}


function unfeatureEvent(ID)
{
	$("#event-add-id").val(ID);
	
	$.ajax({
        url: '/Classes/event.featured.delete.php',
        type: 'POST',
		data: { EventID: ID },
        async: false,
        cache: false,
        timeout: 30000,
        error: function(){
            return true;
        },
        success: function(msg){ 
			refreshLibrary();
            return true;
        }
    });
	
}

var FeatureID = "";
function featureEvent(ID)
{
	$("#event-add-id").val(ID);
	$("#pop_feature").show();
	FeatureID = ID;
}

function featureEventSend(Featured) 
{	
	$.post('/Classes/event.featured.add.php',{
			EventID: FeatureID,
			Featured: Featured
		},
		function() {
			$("#pop_feature").hide();
			changeImage(FeatureID, 'event');
		}
	);
}


function getPage(ID)
{
	resetPage();
	
	$("#section-title").html(sectionTitle[ID]);
	$("#section-desc").html(sectionDesc[ID]);	
	$("#events").html(pageBody[ID]);	
	
	$("#refresh-chart").hide();
	$("#play-chart").hide();
	
	$("#section-selector").show();
	$("#event-selector").show();
	$("#section-header").show();
	$("#events").show();
}



function resetPage()
{
	//charts, profile, reviews, blacklist, songs, logins
	$("#events-list").hide();
	$("#section-selector").hide();
	$("#event-selector").hide();
	$("#section-header").hide();
	$("#section-header").hide();
	$("#section-selector").hide();
	$("#events").hide();
	$("#event-header").hide();
	$("#event").hide();
}

function checkLogin(url)
{
	if (SESSION.id == "")
	{
		ShowLogin();
		return false;
	}	
	else
	{
		if (url != "")
		{
			window.location.replace(url);
		}
	}
}


function addEvent(ID)
{	
	if (ID == undefined)
	{
		if (SESSION.id == "")
		{
			ShowLogin();
			return false;
		}
		
		$("#event-add-helper").html("Use the serach above to search for an event.");
		$("#event-add-results").html("");
		$("#event-add-tickets").hide();
		$("#event-add-review").hide();
		$("#pop_event_form").show();	
		$("#event-add-results").show();
	}
	else
	{
		$("#event-add-id").val(ID);
		$("#pop_event_form").show();	
		getTickets();
	}
}

function showAddTickets(ID)
{	
	if (ID == undefined)
	{
		if (SESSION.id == "")
		{
			ShowLogin();
			return false;
		}
		
		$("#event-add-helper").html("Use the serach above to search for an event.");
		$("#event-add-results").html("");
		$("#event-add-tickets").hide();
		$("#event-add-review").hide();
		$("#pop_event_form").show();	
		$("#event-add-results").show();
	}
	else
	{
		$("#event-add-id").val(ID);
		$("#pop_event_form").show();	
		getTickets();
	}
}


function addSelectedEvent(ID)
{
	$("#event-add-id").val(ID);
	
	$.post('/Classes/event.add.php',{
			EventID: $("#EventID-" + ID).html(),
			EventTitle: $("#EventTitle-" + ID).html(),
			EventDesc: $("#EventDesc-" + ID).html(),
			StartTime: $("#StartTime-" + ID).html(),
			StopTime: $("#StopTime-" + ID).html(),
			VenueID: $("#VenueID-" + ID).html(),
			VenueName: $("#VenueName-" + ID).html(),
			Address: $("#Address-" + ID).html(),
			City: $("#City-" + ID).html(),
			State: $("#State-" + ID).html(),
			PostalCode: $("#PostalCode-" + ID).html(),
			Country: $("#Country-" + ID).html(),
			Latitude: $("#Latitude-" + ID).html(),
			Longitude: $("#Longitude-" + ID).html(),
			PerformerID: $("#PerformerID-" + ID).html(),
			PerformerName: $("#PerformerName-" + ID).html(),
			PerformerShortBio: $("#PerformerShortBio-" + ID).html()
		},
		function() {
			
		}
	);
}
function changeImage(ID, type)
{
	var getImages = 1;
	if (ID != "")
	{
		$("#Flag-EventID").val(ID);		
	}
	
	ID = $("#Flag-EventID").val();
	$("#flag-song-title").html($("#EventTitle-" + ID).html());	
	
	$("#image-type-event").attr('checked', false);
	$("#image-type-venue").attr('checked', false);
	$("#image-type-url").attr('checked', false);
	$("#image-type-search").attr('checked', false);
	$("#image-type-url-box").hide();
	$("#image-type-search-box").hide();
	
	var Search = "";	
	
	if (type == "event")
	{
		$("#image-type-event").attr('checked', true);
		
		Search = $("#EventTitle-" + ID).html() + " " + $("#VenueName-" + ID).html();	
	}
	
	if (type == "venue")
	{
		$("#image-type-venue").attr('checked', true);
		
		Search = $("#VenueName-" + ID).html() + " " + $("#City-" + ID).html();	
	}
	
	if (type == "url")
	{
		$("#image-type-url").attr('checked', true);	
		$("#image-type-url-box").val("");
		$("#image-type-url-box").show();
		
		$("#flag_new_images").html("<div style='font-size: 15px;'>If you know a website where the images are that you want to use, just copy the URL into the form above and hit 'Get Images'.  Once you have found the image you want, just click on it and let me do the rest.</div>");
		
		getImages = 0;
	}
	
	if (type == "search")
	{
		$("#image-type-search").attr('checked', true);
		$("#image-type-search-box").show();
		
		$("#flag_new_images").html("<div style='font-size: 15px;'>Use the form above to see if you can serch for the image you are looking for.  Once you have found it . . . well you get the picture.</div>");
		
		Search = $("#image-type-search-search").val();
		
		if (Search == "")
		{
			getImages = 0;
		}
	}
	
	if (type == "upload")
	{
		$("#image-type-upload").attr('checked', true);
		$("#image-type-upload-box").show();
		
		$("#flag_new_images").html("<div style='font-size: 15px;'>Use the form above to upload a file to the system.  Remember that file size needs to be 116x116.</div>");
		
		Search = $("#image-type-search-search").val();
		
		if (Search == "")
		{
			getImages = 0;
		}
	}
	
	$("#pop_flag").show();
	
	if (getImages == 1)
	{
		$("#flag_new_images").html("");
		$.getJSON('/Classes/images.search.php',{
				Search: Search
			},
			function(data) {
				changeImage_CB(ID, data);
			}
		);
	}
}

function changeImageScrapper()
{
	ID = $("#Flag-EventID").val();	
	$.getJSON('/Classes/images.scrapper.php',{
			URL: $("#image-type-url-search").val()
		},
		function(data) {
			changeImageScrapper_CB(ID, data);
		}
	);
}

function changeImageScrapper_CB(ID, data)
{
	json = data;	
	var template = "";		
	var outHtml = "";
	for (count = 0; count < json.length; count++)
	{	
		var code = template;			
		
		var EventImage = json[count];
		
		code = "<img class=\"link\" width=\"150\" style=\"margin: 8px;\" src=\"" + EventImage + "\" onclick=\"setEventImage(this.src);\" />";
		outHtml += code;
	}	
	
	$("#flag-text").hide();
	$("#flag-update-questions").hide();
	$("#flag_new_images").html(outHtml);
	$("#flag-update-image").show();
}

function changeImage_CB(ID, data)
{
	json = data;	
	var template = "";		
	var outHtml = "";
	for (count = 0; count < json.responseData.results.length; count++)
	{	
		var code = template;			
		
		var EventImage = json.responseData.results[count].unescapedUrl;
		
		code = "<img class=\"link\" width=\"150\" style=\"margin: 8px;\" src=\"" + EventImage + "\" onclick=\"setEventImage(this.src);\" />";
		outHtml += code;
	}	
	
	$("#flag-text").hide();
	$("#flag-update-questions").hide();
	$("#flag_new_images").html(outHtml);
	$("#flag-update-image").show();
	//refreshLibrary();
}

function setEventImage(src)
{
	var ID = $("#Flag-EventID").val();
	
	$.get('/Classes/images.cache.php',{
			id: ID,
			url: src,
			refresh: true
		},
		function() {
			var NewImage = "/Classes/images.cache.php?id=" + ID + "&" + Math.random();
			$("#EventImage-" + ID).html(NewImage);	
			$("#EventImageThumb-" + ID).attr("src", NewImage);	
			$("#pop_flag").hide();			
			refreshLibrary();
		}
	);
}

function getEventImages(ID, Name)
{
	$("#event-add-results").html("");
	$.getJSON('/Classes/images.search.php',{
			event_name: Name
		},
		function(data) {
			getEventImages_CB(ID, data);
		}
	);
}



function getEventImages_CB(ID, data)
{
	json = data;	
	var template = "";		
	var outHtml = "";
	for (count = 0; count < json.responseData.results.length; count++)
	{	
		var code = template;			
		
		var EventImage = json.responseData.results[count].unescapedUrl;
		
		code = "<img class=\"link\" width=\"150\" style=\"margin: 8px;\" src=\"" + EventImage + "\" onclick=\"setImages('" + ID + "', 'Event', this.src);\" />";
		outHtml += code;
	}	
	
	$("#event-add-helper").html("Select the best image for your event");
	$("#event-add-results").html(outHtml);
	
}

function setImages(ID, Type, Src, Callback)
{
	$.post('/Classes/images.set.php',{
			ID: ID,
			Type: Type,
			Src: Src
		},
		function() {
			if (Type == "Event")
			{
				getTickets();	
			}
		}
	);
}

function getTickets()
{	
	$("#event-add-review").hide();	
	$("#event-add-results").hide();	
	
	$("#ticket-general-desc").val("");
	$("#ticket-general-qty").val("");
	$("#ticket-general-price").val("");
	$("#ticket-general-info").val("");
	$("#ticket-general-splits").attr('checked', true);
	
	$("#ticket-allocated-section").val("");
	$("#ticket-allocated-row").val("");
	$("#ticket-allocated-seats").val("");
	$("#ticket-allocated-price").val("");
	$("#ticket-allocated-info").val("");
	$("#ticket-allocated-splits").attr('checked', true);
	
	$("#event-add-helper").html("Add your tickets");
	
	$("#event-add-ticket-options").show();	
	$("#event-add-tickets").show();		
}

// addTickets  = EventID|TicketType|Description|Section|Row|Seats|Qty|Price|Splits|AdditionalInfo

function eventTicketAdd()
{
	var EventID = $("#event-add-id").val();
	
	if ($("#ticket-category-general").is(':checked'))
	{
		addTickets += '{"EventID":"' + EventID + '",';
		addTickets += '"TicketType":"General",';
		addTickets += '"Description":"' + toCapitalize($("#ticket-general-desc").val()) + '",';
		addTickets += '"Section":"null",';
		addTickets += '"Row":"null",';
		addTickets += '"Seats":"null",';
		addTickets += '"Qty":"' + $("#ticket-general-qty").val() + '",';
		addTickets += '"Price":"' + $("#ticket-general-price").val() + '",';
		addTickets += '"Splits":"' + $("#ticket-general-splits").is(':checked') + '",';
		addTickets += '"AdditionalInfo":"' + $("#ticket-general-info").val() + '"},';
	}
	if ($("#ticket-category-allocated").is(':checked'))
	{
		var Qty = findQty($("#ticket-allocated-seats").val());
		
		addTickets += '{"EventID":"' + EventID + '",';
		addTickets += '"TicketType":"Allocated",';
		addTickets += '"Description":"Section: ' + $("#ticket-allocated-section").val() + ', Row: ' + $("#ticket-allocated-row").val() + ', Seat(s): ' + $("#ticket-allocated-seats").val() + '",';
		addTickets += '"Section":"' + $("#ticket-allocated-section").val() + '",';
		addTickets += '"Row":"' + $("#ticket-allocated-row").val() + '",';
		addTickets += '"Seats":"' + $("#ticket-allocated-seats").val() + '",';
		addTickets += '"Qty":"' + Qty + '",';
		addTickets += '"Price":"' + $("#ticket-allocated-price").val() + '",';
		addTickets += '"Splits":"' + $("#ticket-allocated-splits").is(':checked') + '",';
		addTickets += '"AdditionalInfo":"' + $("#ticket-allocated-info").val() + '"},';
	}
	
	eventTicketReview();	
}

function eventTicketReview()
{
	json = eval(cleanJSON(addTickets));	
	
	clearTable("ticket-review-table", 1);
	var table = document.getElementById("ticket-review-table");
	
	if (json.length == 0)
	{
		var rowCount = table.rows.length;
		var row = table.insertRow(rowCount);
		var c0 = row.insertCell(0);	
		
		c0.className = "small";
		c0.innerHTML = "You haven't added any tickets!";
		c0.setAttribute("valign", "top");
		c0.setAttribute("colspan", "4");
		c0.setAttribute("style", "padding: 7px 3px; text-align: center;");
	}
	
	cnt = 1;
	for (count = 0; count < json.length; count++)
	{	
		var reason = "";
	
		var rowCount = table.rows.length;
		var row = table.insertRow(rowCount);
		var c0 = row.insertCell(0);
		var c1 = row.insertCell(1);
		var c2 = row.insertCell(2);
		var c3 = row.insertCell(3);
	
		c0.innerHTML = "<b>" + json[count].Description + "</b><br><span class=\"small\">" + json[count].AdditionalInfo + "</spna>";
		c0.setAttribute("valign", "top");
		c0.setAttribute("style", "padding: 8px 3px 7px;");
	
		c1.innerHTML = json[count].Qty;
		c1.setAttribute("valign", "top");
		c1.setAttribute("style", "padding: 8px 3px 7px; text-align: right;");
	
		c2.innerHTML = json[count].Price;
		c2.setAttribute("valign", "top");
		c2.setAttribute("style", "padding: 8px 3px 7px; text-align: right;");
	
		c3.innerHTML = "<img src='/images/icon_delete.png'>";
		c3.setAttribute("valign", "top");
		c3.setAttribute("style", "padding: 7px 3px; text-align: center; cursor: pointer;");
		c3.setAttribute("onclick", "removeTicket(" + count + ")");
		
		cnt++;
	}
	
	$("#event-add-ticket-options").hide();	
	$("#event-add-helper").html("Review your tickets.");
	
	$("#event-add-tickets").hide();	
	$("#event-add-review").show();		
			
}

function removeTicket(i)
{
	var EventID = $("#event-add-id").val();
	
	json = eval(cleanJSON(addTickets));	
	addTickets = "";
			
	for (count = 0; count < json.length; count++)
	{	
		if (count != i)
		{
			addTickets += '{"EventID":"' + json[count].EventID + '",';
			addTickets += '"TicketType":"' + json[count].TicketType + '",';
			addTickets += '"Description":"' + json[count].Description + '",';
			addTickets += '"Section":"' + json[count].Section + '",';
			addTickets += '"Row":"' + json[count].Row + '",';
			addTickets += '"Seats":"' + json[count].Seats + '",';
			addTickets += '"Qty":"' + json[count].Qty + '",';
			addTickets += '"Price":"' + json[count].Price + '",';
			addTickets += '"AdditionalInfo":"' + json[count].AdditionalInfo + '"},';
		}
	}
	eventTicketReview();
}


function saveTickets()
{
	json = cleanJSON(addTickets);	
	$.post('/Classes/event.tickets.set.php',{
			JSON: json,
			eTixx: $("#ticket-delivery-eTixx").is(':checked'),
			FedEx: $("#ticket-delivery-fedex").is(':checked'),
			WillCall: $("#ticket-delivery-willcall").is(':checked'),
			Contact: $("#ticket-delivery-contact").is(':checked')
		},
		function() {
			addTicketsComplete();	
		}
	);
}

function addTicketsComplete()
{
	$("#pop_event_form").hide();
	refreshLibrary();
}



function getEvent(ID)
{
	
//	EventID-%EventID%
//	VenueID-%EventID%
//	EventTitle-%EventID%
//	EventDesc-%EventID%
//	StartTime-%EventID%
//	EventImage-%EventID%
//	EventVenueMap-%EventID%
//	VenueName-%EventID%
//	VenueType-%EventID%
//	Address-%EventID%
//	City-%EventID%
//	State-%EventID%
//	PostalCode-%EventID%
//	Longitude-%EventID%
//	Latitude-%EventID%
//	PerformerName-%EventID%
//	Bio-%EventID%

	resetPage();
	$("#section-selector").show();
	$("#event-selector").show();
	
	$("#event-header").show();
	$("#event").show();
	
	$("#Event-Details-Img").attr("src", $("#EventImage-" + ID).html());
	$("#Event-Details-EventName").html($("#EventTitle-" + ID).html());	
	$("#Event-Details-StartTime").html($("#StartTime-" + ID).html());	
	$("#Event-Details-VenueName").html($("#VenueName-" + ID).html());	
	
	
	
	



	//API Key: 681570708309d5d13ae7f8ba1fb508c90
	var shareTitle = "Find Tickets to " + toTitleCase($("#EventTitle-" + ID).html()) + " at " + toTitleCase($("#VenueName-" + ID).html()) + " on TixxFixx.com!";
	var shareLink = 'http://www.tixxfixx.com/' + $("#EventTitle-" + ID).html().toLowerCase().replace(/ /g, '-') + '/' + $("#VenueName-" + ID).html().toLowerCase().replace(/ /g, '-') + '/' + $("#EventID-" + ID).html() + '';
	var shareImage = $("#EventImage-%EventID%-" + ID).html();
	
	$('title').text(shareTitle);
	$("meta[property=og\\:title]").attr("content", shareTitle);
	$("meta[property=og\\:description]").attr("content", "Buy, Sale, Trade all your tickets only at TixxFixx.com");
	$("meta[property=og\\:url]").attr("content", shareLink);
	$("meta[property=og\\:image]").attr("content", shareImage);

	
	var shareFacebook = '<img src="/images/icon_facebook.png" width="29" height="29" title="Share on Facebook" class="link" onclick="window.open(\'http://www.facebook.com/sharer.php?u=' + encodeURIComponent(shareLink) + '&t=' + encodeURIComponent(shareTitle) + '\');" />';
	var shareTwitter = '<img src="/images/icon_twitter.png" width="29" height="29" title="Tweet This" class="link" onclick="window.open(\'http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=681570708309d5d13ae7f8ba1fb508c90&service=7&title=' + shareTitle + '&link=' + shareLink + '&template=' + shareTitle + '\');" />';
	var sharePintrest = '<img src="/images/icon_pintrest.png" width="29" height="29" title="Pin It" class="link" onclick="window.open(\'http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(shareLink) + '&media=' + encodeURIComponent(shareImage) + '&description=' + shareTitle + '\');" />';
	var shareBlog = '<img src="/images/icon_blog.png" width="29" height="29" title="Post to Blogger" class="link" onclick="window.open(\'http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=681570708309d5d13ae7f8ba1fb508c90&service=219&title=' + shareTitle + '&link=' + shareLink + '&template=' + shareTitle + '\');" />';
	var shareGoogle = '<img src="/images/icon_google.png" width="29" height="29" title="Google+" class="link" onclick="window.open(\'http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=681570708309d5d13ae7f8ba1fb508c90&service=304&title=' + shareTitle + '&link=' + shareLink + '&template=' + shareTitle + '\');" />';
	var sharePeramLink = '<img src="/images/icon_link.png" width="29" height="29" title="Direct Link" class="link" onclick="window.open(\'' + shareLink + '\');" />';
	
	var shareText = shareFacebook + shareTwitter + sharePintrest + shareBlog + shareGoogle + sharePeramLink;
	
	$("#event-share").html(shareText);
	
	$("#event-comments").html('<div class="fb-comments" data-href="' + shareLink + '" data-num-posts="10" data-width="542"></div>');
	FB.XFBML.parse();
}











function cleanURL(url)
{
	url = url.replace("http://eventful.com", "");
	tempURL = url.split("?");
	url = tempURL[0];
	return url
}


function formatCurrency(num) {
    num = isNaN(num) || num === '' || num === null ? 0.00 : num;
    return parseFloat(num).toFixed(2);
}


function findQty(s)
{
	qty = 0;
	groups = s.split(",");
	
	for (count = 0; count < groups.length; count++)
	{	
		if (groups[count].indexOf("-") > 0)
		{
			items = groups[count].split("-");
			qty = qty + (items[1] - items[0]) + 1;
		}
		else
		{
			qty = qty + 1;
		}
	}
	
	return qty;
}

function toCapitalize(string)
{
    return string.replace( /(^|\s)([a-z])/g , function(m,p1,p2){ return p1+p2.toUpperCase(); } );
}


function cleanJSON(JSON)
{
	JSON = JSON.replace(/(^,)|(,$)/g, "");
	JSON = "[" + JSON + "]";
	return JSON;
}	
	
function clearTable(tableID, header) 
{
	var table = document.getElementById(tableID);
	var rowCount = table.rows.length;
	
	if (rowCount == header) {
		return;
	}
	
	for (var i = header; i < rowCount; i++) {
		try {
			table.deleteRow(header);
		} catch (e) {
			alert(e);
		}
	}
}



/* This is all the old JS cold.  Need to review what is still needed */


function refreshLibrary()
{
	//  var v = $.cookie("value");
	//	var t = $.cookie("type");	
	//	getEvents(event_category, v, t);
	//	getFeatured(event_category, v, t);
	location.reload();
}

function getEventsByName(value, type)
{
	var ID = 0;
	if (type == "chart")
	{
		switch (value)
		{
		case "Events":
		  ID = 1;
		  break;
		case "Tours":
		  ID = 2;
		  break;
		case "Transportation":
		  ID = 3;
		  break;
		default:
		  ID = 0;
		}
	}
	if (type == "genre")
	{
		switch (value)
		{
		case "Pop":
		  ID = 1;
		  break;
		case "Rock":
		  ID = 2;
		  break;
		case "Country":
		  ID = 3;
		  break;
		case "R&B":
		  ID = 4;
		  break;
		case "Hip-Hop":
		  ID = 5;
		  break;
		case "Dance":
		  ID = 6;
		  break;
		case "Decades":
		  ID = 7;
		  break;
		case "LDS Artist":
		  ID = 8;
		  break;
		case "Other":
		  ID = 9;
		  break;
		default:
		  ID = 0;
		}
	}
	getEvents('', ID, type)
}







function getUsers()
{ 
	resetPage();
	$("#section-selector").show();
	$("#event-selector").show();
	$("#users-page").show();
	$("#users").html("<div style='text-align: center; margin-top: 30px;'><img src='/images/wheel_throbber.gif'></div>");	
	
	$.getJSON("/Classes/user.list.php",
	{
	},
		function(data) {
			listUsers(data)
	});	
}

function listUsers(data)
{
	json = data;	
	var template = $("#users-template").html();		
	var outHtml = "";
	
	if (json.users.length == 0)
	{
		outHtml = "<div style='text-align: center;'>Sorry, but no users where returned.</div>";
	}
	else
	{
		for (count = 0; count < json.users.length; count++)
		{	
			var code = template;	
			
			code = code.replace(/%Cnt%/g, count + 1);
			code = code.replace(/%ID%/g, json.users[count].id);
			code = code.replace(/%Source%/g, json.users[count].Source);
			code = code.replace(/%Email%/g, json.users[count].email);
			code = code.replace(/%Username%/g, json.users[count].username);
			code = code.replace(/%FullName%/g, json.users[count].fullname);
			
			if (json.users[count].location.indexOf("@") != -1)
			{
				code = code.replace(/%Location%/g, "");
			}
			else
			{
				code = code.replace(/%Location%/g, json.users[count].location);
			}
			code = code.replace(/%ProfileImage%/g, json.users[count].profile_image);
			code = code.replace(/%SongsSuggested%/g, json.users[count].SongsSuggested);
			code = code.replace(/%Votes%/g, json.users[count].Votes);			
			code = code.replace(/%Likes%/g, json.users[count].Likes);
			code = code.replace(/%Hates%/g, json.users[count].Hates);			
			code = code.replace(/%SongsReviewed%/g, json.users[count].SongsReviewed);
			code = code.replace(/%Contributor%/g, json.users[count].contributor);
			
			var image = "";
			
			if (json.users[count].Source == "facebook")
			{
				image = "http://graph.facebook.com/" + json.users[count].SourceID + "/picture?type=normal";
			}
			
			if (json.users[count].Source == "twitter")
			{
				image = "https://api.twitter.com/1/users/profile_image?screen_name=" + json.users[count].username + "&size=bigger";
			}
			
			code = code.replace(/%thumb-image%/g, "<img width=\"80\" alt=\"" + json.users[count].fullname + "\" src=\"" + image + "\">");
			
			if (json.users[count].LastLogin == "")
			{
				code = code.replace(/%LastLogin%/g, "along time ago");
			}
			else
			{
				code = code.replace(/%LastLogin%/g, jQuery.timeago(json.users[count].LastLogin));
			}
			
			if (json.users[count].contributor == 1)
			{
				code = code.replace(/%contributor-image%/g, "<img src=\"/images/thumbs_up_on.png\" class=\"icon\" id=\"upgrade-%ID%\"  width=\"25\" height=\"25\" />");
			}
			else
			{
				code = code.replace(/%contributor-image%/g, "<img src=\"/images/thumbs_up_off.png\" class=\"icon\" id=\"upgrade-%ID%\"  width=\"25\" height=\"25\" />");
			}	
			
			outHtml += code;
		}
	}
	$("#users").html(outHtml);	
		
}


function ShowLogin()
{
	$("#agree").hide();
	$("#login_buttons").show();
	$("#pop_login").show();	
}


function agree()
{
	$("#agree").hide();
	$("#login_buttons").show();
}

// Lyrics Code

	function showLyrics(ID)
	{
		$("#pop_lyrics").show();	
		$("#Lyrics-SongName").html($("#SongName-" + ID).html());	
		$("#Lyrics-ArtistName").html($("#ArtistName-" + ID).html());
					
				
		$.getJSON('/Classes/lyrics.get.php',{
				id: ID
			},
			function(data) {		
				showLyrics_CB(data);
			}
		);			
	}

	function showLyrics_CB(data)
	{
		json = data;	
		for (count = 0; count < json.lyrics.length; count++)
		{	
			var Lyrics = json.lyrics[count].Lyrics;
			var UserID = json.lyrics[count].UserID;
			var fullname = json.lyrics[count].fullname;
			var AddedOn = json.lyrics[count].AddedOn;
				
			$("#Lyrics-Text").html(Lyrics.replace(/\n/g, "<br />"));	
			$("#Lyrics-SuggestedBy").html("<a href=\"/profile.php?ID=" + UserID + "\">" + fullname + "</a>");	
		}	
	
		$("#Lyrics-loading").hide();	
		$("#Lyrics-body").show();		
	}
	
	function closeLyrics()
	{
		$("#pop_lyrics").hide();	
		$("#Lyrics-loading").show();	
		$("#Lyrics-body").hide();		
		$("#Lyrics-SongName").html();	
		$("#Lyrics-ArtistName").html();
	}


// Player Code

		var playerLoaded = 0;
		var showPlayer = 1;
		function stopPlayer(songID)
		{
			$("#pop_grooveshark_player").hide();
			$("#groovesharkPlayer").html("<div id=\"replaceMe\"></div>");
			$("#play-" + songID).attr("class", "play-button");
			playerLoaded = 0;
		}
		function swapButton(songID)
		{
			$("#play-" + songID).attr("class", "play-loading");			
			setTimeout(function() {$("#play-" + songID).attr("class", "stop-button");	;},4000);
		}
		
		function loadSongPlayer(songID, display)
		{
			$("#play-song-" + songID).attr("class", "play-loading");			
			setTimeout(function() {$("#play-song-" + songID).attr("class", "stop-button");	;},4000);
			loadPlayer(songID, display);
		}
		
        function loadPlayer(songID, display)
        {
			if (SESSION.id == "")
			{
				ShowLogin();
				return false;
			}
			var songArray = songID.split(",");
			
			if (playerLoaded == songID)
			{
				stopPlayer(songID);
			}
			else
			{
				$("#pop_grooveshark_player").show();
				$("#groovesharkPlayer").html("<div id=\"replaceMe\"></div>");
				$(".stop-button").attr("class", "play-button");	
				
					var fn = function() {
						var att = { data:"http://grooveshark.com/widget.swf", id:"LMCplayer", name:"LMCplayer", width:"250", height:"400" };
						var par = { movie:"http://grooveshark.com/widget.swf", wmode:"window", allowScriptAccess:"always", flashvars: "hostname=cowbell.grooveshark.com&songIDs=" + songID + "&bbg=000000&p=1" };
						var id = "replaceMe";
						var swf = swfobject.createSWF(att, par, id);
					};
					if (songArray.length == 1)
					{
						swfobject.addLoadEvent(swapButton(songID));
					}
					swfobject.addDomLoadEvent(fn);
					playerLoaded = songID;
					
					$.post('/Classes/library.play.php',{
							SongID: songID	
						},
						function() {
						}
					);	
					
				
					var playerWindow = window.open('','PlayerWindow','width=250,height=400,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=yes,toolbar=no,top=50,left=50');
					var html = '<html><head><title>TixxFixx</title></head><body style="margin:0;padding:0;"><div id="player">' + $('<div />').append($('#pop_grooveshark_player').clone()).html() + '</div></body></html>';
					playerWindow.document.open();
					playerWindow.document.write(html);
					playerWindow.document.close();
					
					$("#pop_grooveshark_player").hide();
			}
        }
		
		function togglePlayer()
		{
			if (showPlayer == 0)
			{
				$("#toggle-player").attr("src", "images/hide_player.png");
				$("#pop_grooveshark_player").css({"top":"0","left":"50%"}); 	
				showPlayer = 1;
			}
			else
			{
				$("#toggle-player").attr("src", "images/show_player.png");
				$("#pop_grooveshark_player").css({"top":"-999px","left":"-999px"}); 	
				showPlayer = 0;
			}
		}


		
		function showPlayer()
		{
			$("#pop_grooveshark_player").css({"top":"0","left":"50%"}); 
		}
		
		var openPlayer = "0";
		function playAll()
		{
			if (SESSION.id == "")
			{
				ShowLogin();
				return false;
			}
			songID = "";
			for (count = 1; count < $(".SongID").length; count++)
			{
				songID += $(".SongID")[count].innerHTML + ",";
			}
			loadPlayer(songID, 1);
		}
		

	
	
	
	function songComments(ID)
	{	
		//LibraryID-%ID%
		//SongID-%ID%
		//SongName-%ID%
		//ArtistID-%ID%
		//ArtistName-%ID%
		//AlbumID-%ID%
		//AlbumName-%ID%
		//Album-%ID%
		//TinySong-%ID%
		//SubmittedBy-%ID%
		//SubmittedOn-%ID%
		//Likes-%ID%
		//Hates-%ID%
		//Thumb-%ID%
		//UserID-%ID%
		//Source-%ID%
		//Username-%ID%
		//Charts-%ID%
		//Genres-%ID%
		
		
		resetPage();
		$("#section-selector").show();
		$("#event-selector").show();
		
		$("#song-header").show();
		$("#song").show();
		
		var shareImage = "http://www.tixxfixx.com/Classes/images.cache.php?id=" + $("#AlbumID-" + ID).html() + "&size=l&refresh=false&url=http://beta.grooveshark.com/static/amazonart/l" + $("#AlbumID-" + ID).html() + ".jpg";
		var songImage = "http://www.tixxfixx.com/Classes/images.cache.php?id=" + $("#AlbumID-" + ID).html() + "&size=m&refresh=false&url=http://beta.grooveshark.com/static/amazonart/m" + $("#AlbumID-" + ID).html() + ".jpg";
		
		
		$("#Song-Details-Img").attr("src", songImage);
		$("#Song-Details-SongName").html($("#SongName-" + ID).html());
		$("#Song-Details-ArtistName").html($("#ArtistName-" + ID).html());
		$("#Song-Details-Rating").html($("#Rating-" + ID).html());
		$("#Song-Details-Likes").html($("#Likes-" + ID).html());
		$("#Song-Details-Dislikes").html($("#Hates-" + ID).html());

		var Buttons = "<div id=\"play-song-" + $("#SongID-" + ID).html() + "\" onclick=\"loadSongPlayer('" + $("#SongID-" + ID).html() + "', 0);\" class=\"play-button\" style=\"margin: 0px 0px 0 0;\"></div>";
		
		if ($("#Lyrics-" + ID).html() == 1)
		{
			Buttons += "<div id=\"lyrics-" + $("#SongID-" + ID).html() + "\" onclick=\"showLyrics('" + ID + "', 0);\" class=\"lyrics-button\" style=\"margin: 0px 10px 0 0;\"></div>";
		}
		else
		{
			Buttons += "<div id=\"lyrics-" + $("#SongID-" + ID).html() + "\" onclick=\"showLyrics('" + ID + "', 0);\" class=\"lyrics-button\" style=\"margin: 0px 10px 0 0; display: none;\"></div>"
		}
		
		$("#song-buttons").html(Buttons);
		$("#Song-Details-SubmittedBy").html('<a href="/profile.php?ID=' + $("#SubmittedBy-" + ID).html() + '">' + $("#Username-" + ID).html() + '</a>');
		$("#Song-Details-SubmittedOn").html($("#SubmittedOn-" + ID).html());
		
		$("#Song-Details-Charts").html('<span class="chart-name">' + $("#Charts-" + ID).html().replace(/,/g, '</span>, <span class="chart-name">') + '</span>');
		$("#Song-Details-Genres").html('<span class="genre-name">' + $("#Genres-" + ID).html().replace(/,/g, '</span>, <span class="genre-name">') + '</span>');
		
		$("#song-liked-who").html("<div style='text-align: center; margin-top: 30px;'><img src='/images/wheel_throbber.gif'></div>");	
		
		
		$.getJSON('/Classes/user.likes.php',{
				ID: $("#LibraryID-" + ID).html()
			},
			function(data) {
				listLikes(data);
			}
		);

		//API Key: 681570708309d5d13ae7f8ba1fb508c90
		var shareTitle = "" + toTitleCase($("#SongName-" + ID).html()) + " by " + toTitleCase($("#ArtistName-" + ID).html()) + " on TixxFixx!";
		var shareLink = 'http://www.tixxfixx.com/' + $("#ArtistName-" + ID).html().toLowerCase().replace(/ /g, '-') + '/' + $("#SongName-" + ID).html().toLowerCase().replace(/ /g, '-') + '/' + $("#SongID-" + ID).html() + '';
		var shareImage = "http://www.tixxfixx.com/Classes/images.cache.php?id=" + $("#AlbumID-" + ID).html() + "&size=l&refresh=false&url=http://beta.grooveshark.com/static/amazonart/l" + $("#AlbumID-" + ID).html() + ".jpg";
		
		$('title').text(shareTitle);
		$("meta[property=og\\:title]").attr("content", shareTitle);
		$("meta[property=og\\:description]").attr("content", "Create your own music profile and TixxFixx.com");
		$("meta[property=og\\:url]").attr("content", shareLink);
		$("meta[property=og\\:image]").attr("content", songImage);

		
		var shareFacebook = '<img src="/images/icon_facebook.png" width="29" height="29" title="Share on Facebook" class="link" onclick="window.open(\'http://www.facebook.com/sharer.php?u=' + encodeURIComponent(shareLink) + '&t=' + encodeURIComponent(shareTitle) + '\');" />';
		var shareTwitter = '<img src="/images/icon_twitter.png" width="29" height="29" title="Tweet This" class="link" onclick="window.open(\'http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=681570708309d5d13ae7f8ba1fb508c90&service=7&title=' + shareTitle + '&link=' + shareLink + '&template=' + shareTitle + '\');" />';
		var sharePintrest = '<img src="/images/icon_pintrest.png" width="29" height="29" title="Pin It" class="link" onclick="window.open(\'http://pinterest.com/pin/create/button/?url=' + encodeURIComponent(shareLink) + '&media=' + encodeURIComponent(shareImage) + '&description=' + shareTitle + '\');" />';
		var shareBlog = '<img src="/images/icon_blog.png" width="29" height="29" title="Post to Blogger" class="link" onclick="window.open(\'http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=681570708309d5d13ae7f8ba1fb508c90&service=219&title=' + shareTitle + '&link=' + shareLink + '&template=' + shareTitle + '\');" />';
		var shareGoogle = '<img src="/images/icon_google.png" width="29" height="29" title="Google+" class="link" onclick="window.open(\'http://www.shareaholic.com/api/share/?v=1&apitype=1&apikey=681570708309d5d13ae7f8ba1fb508c90&service=304&title=' + shareTitle + '&link=' + shareLink + '&template=' + shareTitle + '\');" />';
		var sharePeramLink = '<img src="/images/icon_link.png" width="29" height="29" title="Direct Link" class="link" onclick="window.open(\'' + shareLink + '\');" />';
		
		var shareText = shareFacebook + shareTwitter + sharePintrest + shareBlog + shareGoogle + sharePeramLink;
		
		$("#song-share").html(shareText);
		
		$("#song-comments").html('<div class="fb-comments" data-href="' + shareLink + '" data-num-posts="10" data-width="562"></div>');
		FB.XFBML.parse();
		
	}

	function listLikes(data)
	{
		json = data;	
		var outHtml = "";
		
		if(!json.users)
		{
			outHtml = "<div class='small' style='text-align: center; padding: 20px;'>Sorry, it doesn't seem like anyone likes this song yet . . . want to be the first?</div>";
		}
		else
		{
			if (json.users.length == 0)
			{
				outHtml = "<div class='small' style='text-align: center; padding: 20px;'>Sorry, it doesn't seem like anyone likes this song yet . . . want to be the first?</div>";
			}
			else
			{
				for (count = 0; count < json.users.length; count++)
				{	
					var code = "";	
					
					if (json.users[count].Source == "facebook")
					{
						image = "http://graph.facebook.com/" + json.users[count].SourceID + "/picture?type=square";
					}
					
					if (json.users[count].Source == "twitter")
					{
						image = "https://api.twitter.com/1/users/profile_image?screen_name=" + json.users[count].username + "&size=normal";
					}
					
					code = "<a href=\"/profile.php?ID=" + json.users[count].id + "\"><img width=\"50\" height=\"50\" title=\"" + json.users[count].fullname + "\" src=\"" + image + "\" style=\"margin: 5px;\"></a>";
					
					outHtml += code;
				}
			}
		}
		$("#song-liked-who").html(outHtml);	
		
	}
	
	
	
	
	
	function toTitleCase(str)
	{
		return str.replace(/\w\S*/g, function(txt){return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();});
	}






// Shopping Cart Functions

	function selectThis(i, v)
	{
		document.getElementById("Ticket-Qty-Select-" + i).options[v].selected = true;
	}

	function addTicketCart(v)
	{
		if (SESSION.id == "")
		{
			ShowLogin();
			return false;
		}
		
		var UserID = SESSION.id;
		var EventID = $("#Ticket-EventID-" + v).html();
		var TicketID = v;
		var Qty = $("#Ticket-Qty-Select-" + v).val();
	
		//alert("EventID: " + EventID + ", UserID: " + UserID + ", TicketID: " + TicketID + ", Qty: " + Qty + "");
	
		$.post('/Classes/cart.add.php',{
				UserID: UserID,
				TicketID: TicketID,
				Qty: Qty
			},
			function() {
				//getEventTickets(EventID);
				getCart();
			}
		);
	}
	
	
	
	function getCart()
	{
			$.getJSON('/Classes/cart.get.php',{
				
			},
			function(data) {
				showCart(data);
			}
		);
	}
	
	function showCart(data)
	{
			
		var template = $("#cart-template").html();	
		
		var outHtml = "";
		
		json = data;	
		
		if (!json.cart)
		{
			$("#cart-tickets-list").html('<div style="text-align: center;">No tickets in your cart</div>');	
			
			$("#cart_continue_button").hide();	
			$("#pop_cart").show();
				
			return false;
		}
		
		var dataLength = json.cart.length;
		for (count = 0; count < dataLength; count++)
		{	
			var code = template;
			
			var CartID = json.cart[count].CartID;
			var EventID = json.cart[count].EventID;
			var VenueID = json.cart[count].VenueID;
			var TicketID = json.cart[count].TicketID;
			var Qty = json.cart[count].Qty;
			var Price = json.cart[count].Price;
			var SubTotal = json.cart[count].SubTotal;
			var TicketType = json.cart[count].TicketType;
			var TicketDesc = json.cart[count].TicketDesc;
			var Section = json.cart[count].Section;
			var Row = json.cart[count].Row;
			var Seats = json.cart[count].Seats;
			var AdditionalInfo = json.cart[count].AdditionalInfo;
			var eTixx = json.cart[count].eTixx;
			var FedEx = json.cart[count].FedEx;
			var WillCall = json.cart[count].WillCall;
			var Contact = json.cart[count].Contact;
			var EventTitle = json.cart[count].EventTitle;
			var EventDesc = json.cart[count].EventDesc;
			var Category = json.cart[count].Category;
			var EventURL = json.cart[count].EventURL;
			var StartTime = json.cart[count].StartTime;
			var VenueName = json.cart[count].VenueName;
			var Address = json.cart[count].Address;
			var City = json.cart[count].City;
			var State = json.cart[count].State;
			var Expire = json.cart[count].Expire;
			
			code = code.replace(/%Cnt%/g, count + 1);
			code = code.replace(/%CartID%/g, CartID);
			code = code.replace(/%EventID%/g, EventID);
			code = code.replace(/%VenueID%/g, VenueID);
			code = code.replace(/%TicketID%/g, TicketID);
			code = code.replace(/%Qty%/g, Qty);
			code = code.replace(/%Row%/g, Row);
			code = code.replace(/%Price%/g, "$"+formatCurrency(Price));
			code = code.replace(/%SubTotal%/g, "$"+formatCurrency(SubTotal));
			code = code.replace(/%TicketType%/g, TicketType);
			code = code.replace(/%TicketDesc%/g, TicketDesc);
			code = code.replace(/%Section%/g, Section);
			code = code.replace(/%Row%/g, Row);
			code = code.replace(/%Seats%/g, Seats);
			code = code.replace(/%AdditionalInfo%/g, AdditionalInfo);
			code = code.replace(/%eTixx%/g, eTixx);
			code = code.replace(/%FedEx%/g, FedEx);
			code = code.replace(/%WillCall%/g, WillCall);
			code = code.replace(/%Contact%/g, Contact);
			code = code.replace(/%EventTitle%/g, EventTitle);
			code = code.replace(/%EventDesc%/g, EventDesc);
			code = code.replace(/%Category%/g, Category);
			code = code.replace(/%EventURL%/g, EventURL);
			code = code.replace(/%StartTime%/g, StartTime);
			code = code.replace(/%StartDateFormated%/g, $.format.date(StartTime, "M/d/yyyy"));
			if ($.format.date(StartTime, "h:mm a") == "12:00 AM")
			{
				code = code.replace(/%StartTimeFormated%/g, "");
			}
			else
			{
				code = code.replace(/%StartTimeFormated%/g, $.format.date(StartTime, "h:mm a"));
			}
			code = code.replace(/%VenueName%/g, VenueName);
			code = code.replace(/%Address%/g, Address);
			code = code.replace(/%City%/g, City);
			code = code.replace(/%State%/g, State);
			code = code.replace(/%Expire%/g, Expire);
			
			code = code.replace(/%Qty%/g, Qty);
			
			if (TicketType == "General")
			{
				code = code.replace(/%ShowRowSeat%/g, "display: none");
			}
			else
			{
				code = code.replace(/%ShowRowSeat%/g, "");
			}
				
				
				
			outHtml += code;
		}
		
		$("#cart-tickets-list").html(outHtml);	
		$("#pop_cart").show();	
	}
	
	function deleteFromCart(CartID, Type)
	{
		$.post('/Classes/cart.delete.php',{
				i: CartID
			},
			function() {
				if (Type == "checkout")
				{
					getCheckout();
				}
				else
				{
					getCart();
				}
					
			}
		);
	}
	
	
	function gotoCheckout()
	{
		window.location.href = "/checkout.php";	
	}
	
	
	
	
	
	
	
	
	function getCheckout()
	{
			$.getJSON('/Classes/cart.get.php',{
				
			},
			function(data) {
				showCheckout(data);
			}
		);
	}
	
	function showCheckout(data)
	{
			
		var template = $("#checkout-template").html();	
		
		var outHtml = "";
		
		json = data;	
		
		if (!json.cart)
		{
			$("#checkout-tickets-list").html('<div style="text-align: center;">No tickets in your cart</div>');	
			$("#checkout-service-charge-display").hide();
			$("#checkout-processing-fee").hide();
			$("#checkout-total-display").hide();
			return false;
		}
		
		var cntSellers = checkSellers(data);
		
		var dataLength = json.cart.length;
		var Total = 0;
		var TotalQty = 0;
		var OrderItems = "";
		for (count = 0; count < dataLength; count++)
		{	
			var code = template;
			
			var CartID = json.cart[count].CartID;
			var EventID = json.cart[count].EventID;
			var VenueID = json.cart[count].VenueID;
			var TicketID = json.cart[count].TicketID;
			var Qty = json.cart[count].Qty;
			var Price = json.cart[count].Price;
			var SubTotal = json.cart[count].SubTotal;
			var TicketType = json.cart[count].TicketType;
			var TicketDesc = json.cart[count].TicketDesc;
			var Section = json.cart[count].Section;
			var Row = json.cart[count].Row;
			var Seats = json.cart[count].Seats;
			var AdditionalInfo = json.cart[count].AdditionalInfo;
			var eTixx = json.cart[count].eTixx;
			var FedEx = json.cart[count].FedEx;
			var WillCall = json.cart[count].WillCall;
			var Contact = json.cart[count].Contact;
			var AddedBy = json.cart[count].AddedBy;
			var username = json.cart[count].username;
			var fullname = json.cart[count].fullname;
			var EventTitle = json.cart[count].EventTitle;
			var EventDesc = json.cart[count].EventDesc;
			var Category = json.cart[count].Category;
			var EventURL = json.cart[count].EventURL;
			var StartTime = json.cart[count].StartTime;
			var VenueName = json.cart[count].VenueName;
			var Address = json.cart[count].Address;
			var City = json.cart[count].City;
			var State = json.cart[count].State;
			var Expire = json.cart[count].Expire;
			
			code = code.replace(/%Cnt%/g, count + 1);
			code = code.replace(/%CartID%/g, CartID);
			code = code.replace(/%EventID%/g, EventID);
			code = code.replace(/%VenueID%/g, VenueID);
			code = code.replace(/%TicketID%/g, TicketID);
			code = code.replace(/%Qty%/g, Qty);
			code = code.replace(/%Row%/g, Row);
			code = code.replace(/%Price%/g, formatCurrency(Price));
			code = code.replace(/%SubTotal%/g, formatCurrency(SubTotal));
			code = code.replace(/%TicketType%/g, TicketType);
			code = code.replace(/%TicketDesc%/g, TicketDesc);
			code = code.replace(/%Section%/g, Section);
			code = code.replace(/%Row%/g, Row);
			code = code.replace(/%Seats%/g, Seats);
			code = code.replace(/%AdditionalInfo%/g, AdditionalInfo);
			code = code.replace(/%eTixx%/g, eTixx);
			code = code.replace(/%FedEx%/g, FedEx);
			code = code.replace(/%WillCall%/g, WillCall);
			code = code.replace(/%AddedBy%/g, AddedBy);
			code = code.replace(/%username%/g, username);
			code = code.replace(/%fullname%/g, fullname);
			code = code.replace(/%Contact%/g, Contact);
			code = code.replace(/%EventTitle%/g, EventTitle);
			code = code.replace(/%EventDesc%/g, EventDesc);
			code = code.replace(/%Category%/g, Category);
			code = code.replace(/%EventURL%/g, EventURL);
			code = code.replace(/%StartTime%/g, StartTime);
			code = code.replace(/%StartDateFormated%/g, $.format.date(StartTime, "M/d/yyyy"));
			
			if (eTixx == "true")
			{
				$("#delivery-eTixx").show();	
			}
			if (WillCall == "true")
			{
				$("#delivery-willcall").show();	
			}
			if (Contact == "true")
			{
				$("#delivery-contact").show();	
			}
			
			
			if ($.format.date(StartTime, "h:mm a") == "12:00 AM")
			{
				code = code.replace(/%StartTimeFormated%/g, "");
			}
			else
			{
				code = code.replace(/%StartTimeFormated%/g, $.format.date(StartTime, "h:mm a"));
			}
			code = code.replace(/%VenueName%/g, VenueName);
			code = code.replace(/%Address%/g, Address);
			code = code.replace(/%City%/g, City);
			code = code.replace(/%State%/g, State);
			code = code.replace(/%Expire%/g, Expire);
			
			code = code.replace(/%Qty%/g, Qty);
			
			if (TicketType == "General")
			{
				code = code.replace(/%ShowRowSeat%/g, "display: none");
			}
			else
			{
				code = code.replace(/%ShowRowSeat%/g, "");
			}
				
			TotalQty = TotalQty + parseInt(Qty);
			Total = Total + parseFloat(SubTotal);
			OrderItems = OrderItems + '{"CartID":"' + CartID + '","TicketID":"' + TicketID + '","Qty":"' + Qty + '","Price":"' + Price + '","SellerID":"' + AddedBy + '"},';
			outHtml += code;
		}
		OrderItems = OrderItems + "0";
		OrderItems = OrderItems.replace(",0", "");
		OrderItems = '{"items":[' + OrderItems + ']}';
		
		var CheckoutFee = (Total + 1) * 0.04;
		
		Total = (Total + 1) * 1.04;
		$("#checkout-total").html("$" + formatCurrency(Total));
		$("#checkout-fee").html("$" + formatCurrency(CheckoutFee));
		$("#Payment_Amount").val(formatCurrency(Total));
		$("#Payment_Qty").val(TotalQty);
		$("#OrderItems").val(OrderItems);
		
		$("#checkout-service-charge-display").show();
		$("#checkout-total-display").show();
		$("#checkout-tickets-list").html(outHtml);	
	}
	
	
	
	function checkSellers(data)
	{
		json = data;	
		
		var dataLength = json.cart.length;
		for (count = 0; count < dataLength; count++)
		{	
			var AddedBy = json.cart[count].AddedBy;				
		}
		return count
	}
	
	function validateInfo()
	{
		var FirstName = $("#FirstName").val();
		var LastName = $("#LastName").val();
		var Address1 = $("#Address1").val();
		var Address2 = $("#Address2").val();
		var City = $("#City").val();
		var State = $("#State").val();
		var Zip = $("#Zip").val();
		var Phone = $("#Phone").val();
		var Email = $("#Email").val();
		
		var showPayPal = 1
		if(FirstName == "")
		{
			showPayPal = 0;	
		}
		if(LastName == "")
		{
			showPayPal = 0;	
		}
		if(Address1 == "")
		{
			showPayPal = 0;	
		}
		if(City == "")
		{
			showPayPal = 0;	
		}
		if(State == "")
		{
			showPayPal = 0;	
		}
		if(Zip == "")
		{
			showPayPal = 0;	
		}
		if(Phone == "")
		{
			showPayPal = 0;	
		}
		if(Email == "")
		{
			showPayPal = 0;	
		}
		if (!$("#Agree-Delivery").is(':checked'))
		{
			showPayPal = 0;
		}
		if (showPayPal == 1)
		{
			$.post('/Classes/user.info.set.php',{
					FirstName: FirstName,
					LastName: LastName,
					Address1: Address1,
					Address2: Address2,
					City: City,
					State: State,
					Zip: Zip,
					Phone: Phone,		
					Email: Email			
				},
				function() {
				}
			);
			
			$("#validate-info").hide();
			$("#paypal-checkout").show();
		}
	}
	
	function ticketDelivery(o)
	{
		$("#ticket-delivery-eTixx").attr('checked', false);
		$("#ticket-delivery-fedex").attr('checked', false);
		$("#ticket-delivery-willcall").attr('checked', false);
		$("#ticket-delivery-contact").attr('checked', false);
		$("#" + o.id).attr('checked', true);
	}
	
	
	
	function deleteTickets(ID)
	{
		$.ajax({
			url: '/Classes/event.tickets.delete.php',
			type: 'POST',
			data: { TicketID: ID },
			async: false,
			cache: false,
			timeout: 30000,
			error: function(){
				return true;
			},
			success: function(msg){ 
				refreshLibrary();
				return true;
			}
		});		
	}

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    
   	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/meta-tags.php");  ?>   
    
    <script>
		SESSION = { 
			"id": "<?php echo $_SESSION["id"]; ?>",
			"contributor": "<?php echo $_SESSION["contributor"]; ?>",
		};
	</script>

    <link href="/include/css/bootstrap.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" href="/include/css/style.css" type="text/css">    
	
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.4.4.min.js"></script>    
	<script type="text/javascript" src="/include/js/jquery.min.js"></script>
    <script type="text/javascript" src="/include/js/jquery.timeago.js"></script>
    <script type="text/javascript" src="/include/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="/include/js/jquery.querystring.js"></script>
    <script type="text/javascript" src="/include/js/jquery.address-1.4.min.js?strict=false&wrap=true"></script>   
	<script type="text/javascript" src="/include/js/jquery.dateFormat.js"></script>                 
    <script type="text/javascript" src="/include/js/verbage/txt-section-header.js"></script>
    <script type="text/javascript" src="/include/js/verbage/txt-list-smack.js"></script>
    <script type="text/javascript" src="/include/js/verbage/txt-static-page.js"></script>
	<script type="text/javascript" src="/include/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/include/js/ajaxupload.js"></script>       
    <script type="text/javascript" src="/include/js/script.js"></script>       
	<script type="text/javascript">
    
      var _gaq = _gaq || [];
      _gaq.push(['_setAccount', 'UA-17228743-1']);
      _gaq.push(['_setDomainName', 'tixxfixx.com']);
      _gaq.push(['_trackPageview']);
    
      (function() {
        var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
        ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
      })();
    
    </script>
    <script type="text/javascript">
	//<![CDATA[
	  (function() {
		var shr = document.createElement('script');
		shr.src = '//dtym7iokkjlif.cloudfront.net/assets/pub/shareaholic.js';
		shr.type = 'text/javascript';
		shr.async = 'true';
		shr.onload = shr.onreadystatechange = function() {
		  var rs = this.readyState;
		  if (rs && rs != 'complete' && rs != 'loaded') return;
		  var apikey = '5f66fdc9ac088f22a37f2cfe67858cfd'
		  try { Shareaholic.init(apikey); } catch (e) {}
		};
		var s = document.getElementsByTagName('script')[0];
		s.parentNode.insertBefore(shr, s);
	  })();
	//]]>
	</script>
    <style type="text/css">
        #ajax-temp {
            display:none;
        }
    </style>    
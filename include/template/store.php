<?php

//Always place this code at the top of the Page
session_start();
 ?>
 
	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/header.php");  ?>

	<div id="container_page">
    
    	<div id="content_page">
    		
			<div id="social">
            	<?php include($_SERVER['DOCUMENT_ROOT']."/include/template/social.php");  ?>            	
	        </div>

    		<div id="logo"><a href="/" title="TixxFixx.com"><img src="/images/logo.png" width="206" height="121" /></a></div>
            
            <div id="contet_body">
            	<?php 
					include($_SERVER['DOCUMENT_ROOT']."/include/template/checkout.php");  
				?>         
            </div>
            
		</div>   
    
   		<div id="footer" style="margin: -198px 0 0; padding: 358px 0 0;"><?php include($_SERVER['DOCUMENT_ROOT']."/include/template/footer.php");  ?></div>	
    </div>
    
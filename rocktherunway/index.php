<?php
include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  

//Always place this code at the top of the Page
session_start();


$_SESSION['ViewLanding'] = 1;

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
            

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Rock the Runway Spring Fashion Show</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/bootstrap-responsive.css" rel="stylesheet">
    <style>

    /* GLOBAL STYLES
    -------------------------------------------------- */
    /* Padding below the footer and lighter body text */

    body {
      padding-bottom: 40px;
      color: #5a5a5a;
	  background: url("/images/bg.png") repeat scroll center 0 #3F3F3F;
    }

	#container {
		width: 1275px;
		margin: 0 auto;	
	}

	#tixxfixx {
		position: absolute;	
		z-index: 1000;
		margin-top: -44px;
	}

    /* CUSTOMIZE THE NAVBAR
    -------------------------------------------------- */

    /* Special class on .container surrounding .navbar, used for positioning it into place. */
    .navbar-wrapper {
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      z-index: 10;
      margin-top: 20px;
      margin-bottom: -90px; /* Negative margin to pull up carousel. 90px is roughly margins and height of navbar. */
    }
    .navbar-wrapper .navbar {

    }

	
	.navbar .nav {
		margin: 0 10px 0 135px;
	}

    /* Remove border and change up box shadow for more contrast */
    .navbar .navbar-inner {
      border: 0;
      -webkit-box-shadow: 0 2px 10px rgba(0,0,0,.25);
         -moz-box-shadow: 0 2px 10px rgba(0,0,0,.25);
              box-shadow: 0 2px 10px rgba(0,0,0,.25);
    }

    /* Downsize the brand/project name a bit */
    .navbar .brand {
      padding: 14px 20px 16px; /* Increase vertical padding to match navbar links */
      font-size: 16px;
      font-weight: bold;
      text-shadow: 0 -1px 0 rgba(0,0,0,.5);
    }

    /* Navbar links: increase padding for taller navbar */
    .navbar .nav > li > a {
      padding: 15px 20px;
    }

    /* Offset the responsive button for proper vertical alignment */
    .navbar .btn-navbar {
      margin-top: 10px;
    }



    /* CUSTOMIZE THE CAROUSEL
    -------------------------------------------------- */

    /* Carousel base class */
    .carousel {
      margin-top: 45px;
    }

    .carousel .container {
      position: relative;
      z-index: 9;
    }

    .carousel-control {
      height: 80px;
      margin-top: 0;
      font-size: 120px;
      text-shadow: 0 1px 1px rgba(0,0,0,.4);
      background-color: transparent;
      border: 0;
      z-index: 10;
    }

    .carousel .item {
      height: 1875px;
    }
    .carousel img {
      position: absolute;
      top: 0;
      left: 0;
      min-width: 1275px;
      height: 1875px;
    }

    .carousel-caption {
      background-color: transparent;
      position: static;
      max-width: 550px;
      padding: 0 20px;
      margin-top: 200px;
    }
    .carousel-caption h1,
    .carousel-caption .lead {
      margin: 0;
      line-height: 1.25;
      color: #fff;
      text-shadow: 0 1px 1px rgba(0,0,0,.4);
    }
    .carousel-caption .btn {
      margin-top: 10px;
    }





    /* RESPONSIVE CSS
    -------------------------------------------------- */

    @media (max-width: 1275px) {

      .container.navbar-wrapper {
        margin-bottom: 0;
        width: auto;
      }
      .navbar-inner {
        border-radius: 0;
        margin: -20px 0;
      }

      .carousel .item {
        height: 1875px;
      }
      .carousel img {
        min-width: 1275px;
        height: 1875px;
      }
    }


    @media (max-width: 767px) {

      .navbar-inner {
        margin: -20px;
      }
	.navbar .nav {
		margin: 0 10px 0 0px;
	}


      .carousel {
        margin-left: -20px;
        margin-right: -20px;
      }
      .carousel .container {

      }
      .carousel .item {
        height: 1128px;
      }
      .carousel img {
        min-width: 767px;
        height: 1128px;
      }
    }

    @media (max-width: 480px) {

      .navbar-inner {
        margin: -20px;
      }

	.navbar .nav {
		margin: 0 10px 0 0px;
	}
      .carousel {
        margin-left: -20px;
        margin-right: -20px;
      }
      .carousel .container {

      }
      .carousel .item {
        height: 706px;
      }
      .carousel img {
        min-width: 480px;
        height: 706px;
      }
    }

    @media (max-width: 380px) {

      .navbar-inner {
        margin: -20px;
      }
	.navbar .nav {
		margin: 0 10px 0 0px;
	}

      .carousel {
        margin-left: -20px;
        margin-right: -20px;
      }
      .carousel .container {

      }
      .carousel .item {
        height: 471px;
      }
      .carousel img {
        min-width: 380px;
        height: 559px;
      }
    }
    </style>

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="assets/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
	<link rel="shortcut icon" href="/favicon.ico">
  </head>

  <body>


    <div id="container">
		<div id="tixxfixx" class="hidden-phone"><a href="http://tixxfixx.com"><img src="/images/logo.png"></a></div>

    <!-- NAVBAR
    ================================================== -->
    <div class="navbar-wrapper">
      <!-- Wrap the .navbar in .container to center it within the absolutely positioned parent. -->
      <div class="container">
        <div class="navbar navbar-inverse">
          <div class="navbar-inner">
            <!-- Responsive Navbar Part 1: Button for triggering responsive navbar (not covered in tutorial). Include responsive CSS to utilize. -->
            <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="brand" href="#"></a>
            <!-- Responsive Navbar Part 2: Place all navbar contents you want collapsed withing .navbar-collapse.collapse. -->
            <div class="nav-collapse collapse">
              <ul class="nav">
                <li class="active"><a href="http://tixxfixx.com/">TixxFixx.com</a></li>
                <li><a href="http://www.tixxfixx.com/boise/events/rock-the-runway-spring-fashion-show/E-EA411E-6EF-9F4EF4F6">But Tickets to This Event</a></li>
                <!-- Read about Bootstrap dropdowns at http://twitter.github.com/bootstrap/javascript.html#dropdowns -->
                <li class="dropdown">
                  <a href="http://tixxfixx.com/" class="dropdown-toggle" data-toggle="dropdown">All Events <b class="caret"></b></a>
                  <ul class="dropdown-menu">
                  	<?php 
					$sql = "select DISTINCT c.Namespace, c.Description from data_event_categories e inner join data_categories c on c.Namespace = e.Namespace";
					$results = mysql_query($sql, $connection);
					$cnt = 1;
					$cntAd = 0;
					while($row = mysql_fetch_array($results, MYSQL_ASSOC)) {

						$Namespace = $row["Namespace"];
						$Description = $row["Description"];
					?>
                    	
	                    <li><a href="http://www.tixxfixx.com/boise/events/<?php echo $Namespace ?>"><?php echo $Description ?></a></li>
						
					<?php
						$cnt ++;
					}
					?>  
                  </ul>
                </li>
              </ul>
            </div><!--/.nav-collapse -->
          </div><!-- /.navbar-inner -->
        </div><!-- /.navbar -->

      </div> <!-- /.container -->
    </div><!-- /.navbar-wrapper -->



    <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide">
      <div class="carousel-inner">
        <div class="item active">
          <a href="http://www.tixxfixx.com/boise/events/rock-the-runway-spring-fashion-show/E-EA411E-6EF-9F4EF4F6"><img src="assets/img/front.jpg" alt=""></a>
          <div class="container">
            <div class="carousel-caption">
              
            </div>
          </div>
        </div>
        <div class="item">
          <a href="http://www.tixxfixx.com/boise/events/rock-the-runway-spring-fashion-show/E-EA411E-6EF-9F4EF4F6"><img src="assets/img/back.jpg" alt=""></a>
          <div class="container">
            <div class="carousel-caption">
              
            </div>
          </div>
        </div>
      </div>
      <a class="left carousel-control" href="#myCarousel" data-slide="prev">&lsaquo;</a>
      <a class="right carousel-control" href="#myCarousel" data-slide="next">&rsaquo;</a>
    </div><!-- /.carousel -->



    </div><!-- /.container -->



    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/bootstrap-transition.js"></script>
    <script src="assets/js/bootstrap-alert.js"></script>
    <script src="assets/js/bootstrap-modal.js"></script>
    <script src="assets/js/bootstrap-dropdown.js"></script>
    <script src="assets/js/bootstrap-scrollspy.js"></script>
    <script src="assets/js/bootstrap-tab.js"></script>
    <script src="assets/js/bootstrap-tooltip.js"></script>
    <script src="assets/js/bootstrap-popover.js"></script>
    <script src="assets/js/bootstrap-button.js"></script>
    <script src="assets/js/bootstrap-collapse.js"></script>
    <script src="assets/js/bootstrap-carousel.js"></script>
    <script src="assets/js/bootstrap-typeahead.js"></script>
    <script>
      !function ($) {
        $(function(){
          // carousel demo
          $('#myCarousel').carousel()
        })
      }(window.jQuery)
    </script>
    <script src="assets/js/holder/holder.js"></script>
  </body>
</html>

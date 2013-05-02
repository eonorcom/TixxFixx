<?php
//error_reporting(E_ALL);
error_reporting (0);
ini_set("display_errors", 0);

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'beaver');
define('DB_DATABASE', 'tixxfixx');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());


global $ShowLandingPage;

$ShowLandingPage = 0;
?>
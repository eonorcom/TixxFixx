<?php
session_start();


$referer = parse_url($_SERVER['HTTP_REFERER']);
$_SESSION['login_redirect'] = $referer["path"];

if ($_SERVER['SERVER_NAME'] == "tixx")
{
	$_SESSION['id'] = 1;
	$_SESSION['contributor'] = 1;
	$_SESSION['fullname'] = "Ryan Riley";
	$_SESSION['username'] = "Block2150";
	header("Location: " . $_SESSION['login_redirect']);
	exit();
}

if (array_key_exists("login", $_GET)) {
    $oauth_provider = $_GET['oauth_provider'];
    if ($oauth_provider == 'twitter') {
        header("Location: login-twitter.php");
    } else if ($oauth_provider == 'facebook') {
        header("Location: login-facebook.php");
    }
}


?>
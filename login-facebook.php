<?php

require 'facebook/facebook.php';
require 'include/config/fbconfig.php';
require 'include/config/functions.php';

$facebook = new Facebook(array(
            'appId' => APP_ID,
            'secret' => APP_SECRET,
            ));

$user = $facebook->getUser();

if ($user) {
  try {
    // Proceed knowing you have a logged in user who's authenticated.
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }






    if (!empty($user_profile )) {
        # User info ok? Let's print it (Here we will be adding the login and registering routines)
  		$twitter_otoken = '';
		$twitter_otoken_secret = '';
        $username = $user_profile['username'];
        $fullname = $user_profile['name'];
			 $uid = $user_profile['id'];
		   $email = $user_profile['email'];
        $location = $user_profile['location']['name'];
        $profile_image = "http://graph.facebook.com/$username/picture";
        $user = new User();
        $userdata = $user->checkUser($uid, 'facebook', $username,$email,$twitter_otoken,$twitter_otoken_secret, $fullname, $location,$profile_image);
        if(!empty($userdata)){
            session_start();
			$_SESSION['logout_url'] = $facebook->getLogoutUrl(array( 'next'  => 'http://www.tixxfixx.com/logout.php'));
            $_SESSION['id'] = $userdata['id'];
			$_SESSION['oauth_id'] = $uid;
            $_SESSION['fullname'] = $userdata['fullname'];
			$_SESSION['email'] = $email;
            $_SESSION['oauth_provider'] = $userdata['oauth_provider'];
            $_SESSION['contributor'] = $userdata['contributor'];
            $_SESSION['username'] = $username;
            $_SESSION['profile_image'] = $profile_image;
            header("Location: " . $_SESSION['login_redirect']);
        }
    } else {
        # For testing purposes, if there was an error, let's kill the script
        die("There was an error.");
    }
} else {
    # There's no active session, let's generate one
	$login_url = $facebook->getLoginUrl(array( 'scope' => 'email'));
    header("Location: " . $login_url);
}
?>

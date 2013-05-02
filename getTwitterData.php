<?php
require($_SERVER['DOCUMENT_ROOT']."/twitter/twitteroauth.php");
require($_SERVER['DOCUMENT_ROOT']."/include/config/twconfig.php");
require($_SERVER['DOCUMENT_ROOT']."/include/config/functions.php");
session_start();

if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
    // We've got everything we need
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
// Let's request the access token
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
// Save it in a session var
    $_SESSION['access_token'] = $access_token;
// Let's get the user's info
    $user_info = $twitteroauth->get('account/verify_credentials');
// Print user's info
    echo '<pre>';
    print_r($user_info);
    echo '</pre><br/>';
    if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: login-twitter.php');
    } else {
	    $twitter_otoken=$_SESSION['oauth_token'];
	    $twitter_otoken_secret=$_SESSION['oauth_token_secret'];
	    $email='';
        $uid = $user_info->id;
        $username = $user_info->screen_name;
        $user = new User();
		$fullname = $user_info->name;
		$location = $user_info->location;
		$profile_image = $user_info->profile_image_url;
        $userdata = $user->checkUser($uid, 'twitter', $username,$email,$twitter_otoken,$twitter_otoken_secret,$fullname,$location,$profile_image);
        if(!empty($userdata)){
            session_start();
            $_SESSION['logout_url'] = $userdata['/logout.php'];
            $_SESSION['id'] = $userdata['id'];
			$_SESSION['oauth_id'] = $uid;
            $_SESSION['username'] = $userdata['username'];
            $_SESSION['oauth_provider'] = $userdata['oauth_provider'];
            $_SESSION['contributor'] = $userdata['contributor'];
            $_SESSION['fullname'] = $userdata['fullname'];
            $_SESSION['profile_image'] = $profile_image;
            header("Location: " . $_SESSION['login_redirect']);
        }
    }
} else {
    // Something's missing, go back to square 1
    header('Location: login-twitter.php');
}
?>

<?php

require($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");

class User {

    function checkUser($uid, $oauth_provider, $username,$email,$twitter_otoken,$twitter_otoken_secret,$fullname,$location,$profile_image) 
	{
        $query = mysql_query("SELECT * FROM `users` WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'") or die(mysql_error());
        $result = mysql_fetch_array($query);
        if (!empty($result)) {
			$sql = "UPDATE users set username = '$username', fullname = '$fullname', location = '$location', LastLogin = NOW() WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'";
            $query = mysql_query($sql) or die(mysql_error());    
        } else {
            #user not present. Insert a new Record
            $query = mysql_query("INSERT INTO users (oauth_provider, oauth_uid, username, fullname, email, location, twitter_oauth_token, twitter_oauth_token_secret, LastLogin) VALUES ('$oauth_provider', $uid, '$username', '$fullname','$email','$location','$twitter_otoken','$twitter_otoken_secret', NOW())") or die(mysql_error());
            $query = mysql_query("SELECT * FROM users WHERE oauth_uid = '$uid' and oauth_provider = '$oauth_provider'");
            $result = mysql_fetch_array($query);
            return $result;
        }
        return $result;
    }

    

}

?>

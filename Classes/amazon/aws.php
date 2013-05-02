<?php
//aws.php
//handles the actual AWS request and manages a cache to speed things up
//part of stand-alone PHP example script to use the Amazon Web Services interface
//written by Jaap van Ganswijk (JvG) <ganswijk@xs4all.nl>
//you can use this version under any version of the GPL (GNU Public License)
//20020816/JvG, released under the GNU GPL
//20091105/JvG, separated from the main file
//20090623/JvG, busy adding the signing that Amazon requires from 20090815
//20090804/JvG, rewrote the scripts to make the new version (with signing) more like the old version so that the caching would work again but didn't test it yet, this also made show_url work again
//20090812/JvG, added the comments for 20090804 and 20090812 and tested the caching and I am going to try to put the script online
//20090816/JvG, always use signed request, started adding better time measurement
//20090826/JvG, script will now create cache directory itself

if      (file_exists("etc.php")) {  //available in this directory?
  include_once "etc.php";
}
else if (file_exists($file_etc_php=pathinfo(__FILE__,PATHINFO_DIRNAME).DIRECTORY_SEPARATOR."etc.php")) {  //available in an amazon include directory?
  include_once $file_etc_php;
}
else {
  echo "<h1>Jaap's Amazon Script</h1>\n";
  echo "<h2>Installation</h2>\n";
  if ($_POST['do']=='make_etc_file' and $_POST['public_key'] and $_POST['private_key']) {
    $r='<?php'."\n".
       '$public_key ="'.$_POST['public_key' ].'";'."\n".
       '$private_key="'.$_POST['private_key'].'";'."\n";
    file_put_contents('etc.php',$r) or die("can't write 'etc.php' file");
    echo "File 'etc.php' written, please reload the page (using F5 for example, you can ignore the popup-window about resending data).<br />\n";
  }
  else {
    echo "You don't have a file called 'etc.php' with your public and private key yet.<br />\n";
    echo "You can fill in this form and I'll make if for you:<br />\n";
    echo "<form method='post'>\n";
    echo "  public key:&nbsp;&nbsp;<input name='public_key' size='25' /><br />\n";
    echo "  private key:&nbsp;<input name='private_key' size='50' /><br />\n";
    echo "  <input type='hidden' name='do' value='make_etc_file' />\n";
    echo "  <input type='submit' value='make the etc.php file' />\n";
    echo "</form>\n";
    echo "Or you can make it yourself (may be safer). It should contain:<br />\n";
    echo "<p />\n";
    echo "&lt;?php<br />\n";
    echo '$public_key="YOUR_PUBLIC_KEY";<br />'."\n";
    echo '$private_key="YOUR_PRIVATE_KEY";<br />'."\n";
    echo "<p />\n";
    echo "If you haven't gotten them already, you should be able to get them <a href='https://aws-portal.amazon.com/gp/aws/developer/account/index.html?ie=UTF8&action=access-key'>here</a>.<br />\n";

  }
  die("--stopping the execution of the script now--");
}
  
require_once "data.php";                //static data about Amazon (servers, search fields) v3-
require_once "data_v4.php";             //static data about Amazon (servers, search fields) v4+
require_once "aws_signed_request.php";  //see: http://mierendo.com/software/aws_signed_query/, please note that I'm using an slightly adapted version of the script: I do my own XML-interpreting

//20090817: this is no longer used it seems:
//$dev_token='D2WMCOIPS9D14E';
//you can replace this with your own developer token after you have changed the script a lot
//get one from http://associates.amazon.com/exec/panama/associates/join/developer/application.html
//see:
//http://forums.prospero.com/n/mb/message.asp?webtag=am-assocdevxml&msg=378.1&ctx=0

function aws_request($parameters) {
  global $Aserver;      //information about AWS servers
  global $locale;       //which server to use?
  global $show_url;     //show the URL that is send to AWS?
  global $tab;          //current tabulation for printing HTML
  global $Amicrotime;   //for debugging the time consumption of parts of the script
  global $jaap;         //my own debugging flag. When you are running the script it should be false
  global $public_key;   //your public key in etc.php
  global $private_key;  //your private key in etc.php

  if ($jaap) print_array($parameters);
//echo "public_key=$public_key<br />\n";
//echo "private_key=$private_key<br />\n";
  //20090623: The signed request version requires these two parameters:
  //$public_key="xxxxxx";   //you have to get this from Amazon on page https://aws-portal.amazon.com/gp/aws/developer/account/index.html?ie=UTF8&action=access-key
  //$private_key="xxxxxx";  //you have to get this from Amazon on page https://aws-portal.amazon.com/gp/aws/developer/account/index.html?ie=UTF8&action=access-key
  //i have to keep my own private_key secret so I can't list it here, sorry
  if (!isset($public_key) or !$public_key or !isset($private_key) or !$private_key) {
    die("You don't seem to have a proper etc.php file. So please remove (rename) it and see what this script says.");
  }
  //this will create the filename for the cache file
  //it should only contain non-static search parameters and not static data for your site
  if ($jaap) echo "locale=$locale<br />"; 
  $ext=$Aserver[$locale]['ext'];  //extension of server, see data.php
  $file_data=$ext;
  ksort($parameters);
  if ($jaap) {
    print_array($parameters);
  }
  foreach ($parameters as $i=>$d) {
    $file_data.='&'.$i.'='.$d;
  }
  if ($jaap) echo "ext=$ext<br />"; 
  $file=aws_signed_request($ext,$parameters,$public_key,$private_key);  //20090804: sign the request
  
  if (isset($show_url) and $show_url) {
    echo $tab."<hr />\n";
    echo $tab."this is because of show_url-flag induced debugging:<br />\n";
    echo $tab."<p />\n";
    echo $tab."Request data:<br />\n";
    echo $tab."$file_data<br />\n";
    echo $tab."<p />\n";
    echo $tab."Asking Amazon's XML interface for URL:<br />\n";
    echo $tab."$file<br />\n";
    echo $tab."<hr />\n";
  }
  
  //do you want to use caching?
  $cache_time=3600;  //60s*60m=1h, in seconds how long a cache entry may be used
  //Use 0 for no caching
  //Amazon requires a maximum of one day for most data,
  //but unfortunately only one hour for prices, I think.
  
  $time0=time();
  
  $Amicrotime['cache read'][0]=getmicrotime();  //time before reading cache
  
  $cachedir='cache/';  //directory where to cache things.
  //make sure the script can make this directory or make it yourself and give it the right permissions so the script can read and write in the directory.
  //under Unix: chmod a+rw cache
  //If you don't want the contents of the directory to be accessible via the WWW, put the directory outside of the WWW-pages tree, like in /tmp or a level higher: ../
  
  if (file_exists($cachedir) and is_dir($cachedir)) {
    //Okay: directory already exists
  }
  else {
    if (mkdir($cachedir)) {
      //echo $tab."cache directory created<br />\n";
    }
    else die("can't make cache directory");
  }
  if (is_readable($cachedir) && is_writable($cachedir)) {
    //Okay: directory is readable and writable by the script
  }
  else {
    die("cache directory is not readable and writable");
  }
  
  if ($jaap) {
    $cache_time=0;  //don't cache
  }
  
  //first we clean out the cache
  //(20091105: this can be written more compact using a new dir function...)
  if ($cache_time and $hd=opendir($cachedir)) {
    while ($fn=readdir($hd)) {
      if ($time0-filemtime($cachedir.$fn)>=$cache_time) {     //is the file too old?
        if (!($fn=='.' or $fn=='..')) unlink($cachedir.$fn);  //remove it
      }
    }
    closedir($hd);
  }
  
  //this is the actual program, it does:
  //- send the request using fopen()
  //- read the returned data into an XML string
  //- convert the XML string into an array
  //- print the array
  
  //$cache_file_name=$cache.md5($file);                       //determine the name of the cache file for the current request
  $cache_file_name=$cachedir.$file_data;                      //determine the name of the cache file for the current request
  if ($jaap) echo $tab."file_data=$file_data<br />\n";
  
  //if ($cache_time and                                       //are we caching?
  //    is_readable($cache_file_name) and                     //file already readable in cache?
  //    $hf=fopen($cache_file_name,'r')) {                    //can it be opened?
  //  $A=unserialize(fread($hf,filesize($cache_file_name)));
  //  fclose($hf);
  //  $Amicrotime['cache'][1]=getmicrotime();                 //time after reading cache
  //}
  if ($cache_time and                                         //are we caching?
      file_exists($cache_file_name) and                       //file already in cache? should be readable
      $filecontents=file_get_contents($cache_file_name)) {    //file already in cache?
    //echo $tab."filecontents:<pre>".htmlentities($filecontents)."</pre><br />\n";
    $Amicrotime['cache read'][1]=getmicrotime();              //time after reading cache
  }
  else {
    $Amicrotime['cache read'][1]=getmicrotime();              //time after using cache and requesting AWS
    $Amicrotime['AWS'       ][0]=getmicrotime();              //time after using cache and requesting AWS
    //if your provider doesn't allow file_get_contents() on foreign files,
    //uncomment the next lines instead:
    //20080730: Sorry haven't retested the above code lately
    //$session=curl_init($file);
    //curl_setopt($session,CURLOPT_HEADER,false);
    //curl_setopt($session,CURLOPT_RETURNTRANSFER,true);
    //$sfile=curl_exec($session);
    //curl_close($session);
    if ($filecontents=file_get_contents($file)) {             //get the file from Amazon, did we succeed?
      $Amicrotime['AWS'][1]=getmicrotime();                   //time after getting AWS data
      if ($cache_time) {                                      //are we caching?
        $Amicrotime['cache write'][0]=getmicrotime();         //time before writing to cache
        file_put_contents($cache_file_name,$filecontents);    //write the cache file
        $Amicrotime['cache write'][1]=getmicrotime();         //time after writing to cache
      }
    }
    else die(xu("can't get data from Amazon").".\n");
  }
  
  //debug: want to see the XML?
  //you can easily use this debugging tool by adding '&show_xml=1' to the URL of this script
  if (isset($show_xml) and $show_xml) {       //print the raw XML for debuggging?
    echo $tab."showing the xml:<br />\n";
    echo $tab."<pre>\n";
    echo $tab.htmlentities($filecontents);    //print the file
    echo $tab."</pre>\n";
    echo $tab."<hr />\n";
  }
  
  $Amicrotime['XML'][0]=getmicrotime();          //time before XML decoding
  
  //decode the XML:
  if ($A=simplexml_load_string($filecontents));  //decode the XML to an object
  else die("can't decode the XML data");
  
  $Amicrotime['XML'][1]=getmicrotime();          //time after XML decoding
  return $A;
}

//end

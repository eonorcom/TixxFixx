<?php

error_reporting(error_reporting()&~E_NOTICE);  //this prevents a lot of warnings on a Windows server, but you can comment-out this line for debugging

$Amicrotime['total'][0]=getmicrotime();  //time at start of total process
$tab='    ';  //tab how much?
$output = '';
if (!defined($jaap)) $jaap=$false;  //($_SERVER['PHP_SELF']=='/jaap/php/amazon/amazonv4.php' or $_SERVER['PHP_SELF']=='/jaap/php_linux/amazon/amazonv4.php');  //I use this flag to develop new things for the script on my local PC.

$jb=false;  //this is a test for someone, please change it to false if it isn't already
$Adefault=array(
  'language'           =>'en',           //what language to render the page in
  'locale'             =>'us',           //which server's products? available: ca,de,fr,jp,uk,us
//'mode'               =>'books',        //what product category?
  'page'               =>1,              //first page to show (we are counting from 1 not 0)
//'search'             =>'Machiavelli',  //what to search for?
  'operation'          =>'ItemSearch',   //what to do?
  'searchindex'        =>'Books',        //what product category for search?
  'searchparameter'    =>'Author',       //what kind of search?
  'searchparameterdata'=>'Machiavelli',  //what to search for?
  //here some debugging flags you can put at the end of the URL to call this script with, like: '?show_array=true'
  'jaap'               =>false,          //my own debugflag to test new things
  'show_array'         =>false,          //debug: show complete incoming array? You can use this to see what other information Amazon is sending
  'show_url'           =>false,          //debug: show XML request url to be send to Amazon?
  'show_xml'           =>false,          //debug: show incoming XML code from Amazon?
);
//change the debug options to true if you want to activate them or call the script with '?show_array=true' to see what actual information you're getting from Amazon and how little my standard script is actually showing of it

require_once "data.php";      //static data about Amazon (servers, search fields) v3-
require_once "data_v4.php";   //static data about Amazon (servers, search fields) v4+
require_once "language.php";  //translate the output to the prefered language of the user
require_once "aws.php";       //see: http://mierendo.com/software/aws_signed_query/, please note that I'm using an slightly adapted version of the script: I do my own XML-interpreting

//20090624: the following isn't relevant anymore it seems, 20091122: yes it is!
$Aassociates_id=array(
  'de'=>'chipdir00' ,  // <-- replace with your amazon.de    associate ID, or leave it as it is
  'fr'=>'chipdir010',  // <-- replace with your amazon.fr    associate ID, or leave it as it is
  'jp'=>'INVALID'   ,  // <-- replace with your amazon.co.jp associate ID, or leave it as it is
  'uk'=>'chipdir03' ,  // <-- replace with your amazon.co.uk associate ID, or leave it as it is
  'us'=>'httpldsmusicc-20'   ,  // <-- replace with your amazon.com   associate ID
);

$f_user_search=false;

//=============================================================================
//==You don't have to change anything below this line to start earning money.==
//=============================================================================

if ($jaap) {
  print_array($_GET,$tab);
}

//what are the user's prefered languages?
$Ahttp_lang=split(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);

if ($jaap) {
  print_array($Ahttp_lang,$tab);
}

//try to find the visitor's prefered language, this is still experimental
foreach ($Ahttp_lang as $i=>$d) {
  if ($Axl[$l=substr($d,0,2)]) {
    $pref_lang=$l;
    break;
  }
}

if (isset($pref_lang)) {
  $Adefault['language']=$pref_lang;
  if ($jaap) {
    echo $tab."prefered available language='$pref_lang'<br />\n";
  }
}

//for all parameters see if the user has overruled it or use the default
foreach ($Adefault as $i=>$d) {
  $$i=isset($_GET[$i])?$_GET[$i]:$d;
  if ($jaap) echo $tab."$i = '".$$i."'<br />\n";
}

//this is a test for someone:
if ($jb) {
  $operation ='SellerListingSearch';
  $show_array=1;
}

//use which servers?
//$norserver=$Aserver[$locale]['nor'];
//$xmlserver=$Aserver[$locale]['xml'];

//20090817: this is no longer used it seems:
//$dev_token='D2WMCOIPS9D14E';
//you can replace this with your own developer token after you have changed the script a lot
//get one from http://associates.amazon.com/exec/panama/associates/join/developer/application.html
//see:
//http://forums.prospero.com/n/mb/message.asp?webtag=am-assocdevxml&msg=378.1&ctx=0

//this is the data that is used to form the request for AWS
//this is the part that is search specific

  $parameters=array(
    'Operation'       =>$operation              ,
    'Keywords'        =>urlencode($search)      ,
    'SearchIndex'     =>$searchindex            ,  //Books for example.
    "$searchparameter"=>$searchparameterdata    ,
    'ItemPage'        =>$page                   ,  //which page?
//  'Service'         =>'AWSECommerceService'   ,  //this makes it version 4
//  'SubscriptionId'  =>$subscriptionid         ,  //is this correct?
//  'AWSAccessKeyId'  =>$awsaccesskeyid         ,  //is this correct?
    'AssociateTag'    =>$Aassociates_id[$locale],
    'ResponseGroup'   =>'Medium'                ,  //Small, Medium, Large or SellerListing
  );

$A=aws_request($parameters);  //do the AWS request via cache and decode the XML
$Amicrotime['XML'][1]=getmicrotime();        //time after XML decoding

//debug: show the array or object
//you can easily use this debugging tool by adding '&show_array=1' to the URL of this script
if ($show_array) {       //show the array for debugging?
  print_array($A,$tab);  //show the complete array
}

//show the stuff

$Amicrotime['show'][0]=getmicrotime();         //time before showing stuff

if (isset($A->Error)) {
  $c=$A->Error->Code;
  $e=$A->Error->Message;
  echo $tab."Amazon error: $c: $e<br />\n";
}
else if ($A->Items->Request->IsValid!='True') {
  $c=$A->Items->Request->Errors->Error->Code;
  $e=$A->Items->Request->Errors->Error->Message;
  echo $tab."Amazon error: $c: $e<br />\n";
}
else {
  print_products($A,$tab);
}

//print all the products
function print_products($A,$tab='') {
  global $jaap;
  global $language;
  global $locale;
  global $operation;
  global $page;
  global $search;
  global $searchparameter;
  global $searchparameterdata;

  switch ($operation) 
  {
  	case 'SellerListingSearch':
    	die("sorry but SellerListingSearch doesn't work yet");
	    $items  =$A['SellerListingSearchResponse']['SellerListings'];
	    $subnode='SellerListing';
	    break;
	default:
		$items    =$A    ->Items;
	    $aitems=(array)$items;       //it is very strange that this and the next line works and not the outcommented line before this one
	    $items_sub=$aitems['Item'];
    break;
  }
  $npro=$items->TotalResults;
  $npag=$items->TotalPages;
  
  echo '{"results":[';
  if (is_array($items_sub) and $items_sub[0]) {
    foreach ($items_sub as $i=>$E) {
      $output .= print_product($E);
    }
  }
  else {
    $output .= print_product($D,$tab.'    ');
  }
  
  $output = substr($output,0,strlen($output)-1); 
  echo $output;
  
  echo ']}';
}

//print one Amazon product
//version 4
function print_product($E) 
{
	global $jaap;
	global $locale;
  
	$jaap = true;

	$out = "";
	$quotes = array('/"/',"/'/");
	$replacements = array('%22','%27');
	
	if ($E) 
	{
		$type=$d=$E->ItemAttributes->ProductTypeName;
		if ($type == "DOWNLOADABLE_MUSIC_TRACK")
		{
			$asin=$E->ASIN;
			$out .= '{"ASIN":"'.$asin.'",';
			  
			$E2A=(array)$E;
			$url=$E2A['DetailPageURL'];
			
			
			if ($d=$E->MediumImage) {
				$iu=$d->URL;
				$ih=$d->Height;
				$iw=$d->Width;
				$out .= '"AlbumArt":"'.$iu.'",';
			}
			
			if ($d=$E->SmallImage) {
				$iu=$d->URL;
				$ih=$d->Height;
				$iw=$d->Width;
				$out .= '"AlbumThumb":"'.$iu.'",';
				$out .= '"Width":"'.$iw.'",';
				$out .= '"Height":"'.$ih.'",';
			}
			
			if ($d=$E->ItemAttributes->Title) {
				$out .= '"Song":"'.preg_replace($quotes,$replacements,$d).'",';
			}
			
			if ($d=$E->ItemAttributes->Creator) {
				$out .= '"Artist":"'.preg_replace($quotes,$replacements,$d).'"},';
			}
		}
	}
	
	//print_array($E2A);

	return $out;}

//make link to other page (next, previous etc.)
function make_link_to_page($page,$s) {
  global $language;
  global $locale;
  global $search;
  global $searchindex;
  global $searchparameter;
  global $searchparameterdata;

  return "<a href='?".
         'language'           .'='.$language                      .'&'.
         'locale'             .'='.$locale                        .'&'.
         'page'               .'='.$page                          .'&'.
         'searchindex'        .'='.$searchindex                   .'&'.
         'searchparameter'    .'='.$searchparameter               .'&'.
         'searchparameterdata'.'='.urlencode($searchparameterdata).'&'.
         "'>".xu($s)."</a>";
}

//print an array or object
//(for debugging)
function print_array($A,$tab='') {
  if (is_object($A)) {
    echo   $tab."object:<br >\n";
    print_array((array)$A,$tab);
  }
  else if (is_array($A)) {
//  print_r($A);
    echo   $tab."<table border='1'>\n";
    echo   $tab."  <tbody>\n";
//  echo   $tab."    COUNT=".count($A)."\n";
//  if (is_object($A)) {
//    echo   $tab."    COUNT=".count($A)." - ".$A['0']."\n";
//  }
    foreach ($A as $i=>$d) {
      echo   $tab."    <tr>\n";
      echo   $tab."      <td valign='top'>$i</td>\n";
//    print_r($d);
      if (is_string($d)) {
//      echo $tab."      STRING\n";
//      print_r($d);
//      echo $tab."      <td><pre>".htmlentities($d)."</pre></td>\n";
        echo $tab."      <td>".htmlentities($d)."</td>\n";
      }
      else if (is_array($d)) {
//      echo $tab."      ARRAY or OBJECT\n";
        echo $tab."      <td>\n";
        print_array($d,$tab.'        ');
        echo $tab."      </td>\n";
      }
      else if (is_object($d)) {
//      echo $tab."      ARRAY or OBJECT\n";
        echo $tab."      <td>object:\n";
        print_array((array)$d,$tab.'        ');
        echo $tab."      </td>\n";
      }
      else {
//      echo $tab."      ELSE\n";
//      print_r($d);
//      echo $tab."      <td><pre>".htmlentities($d)."</pre></td>\n";
        echo $tab."      <td>".htmlentities($d)."</td>\n";
      }
      echo   $tab."    </tr>\n";
    }
    echo     $tab."  </tbody>\n";
    echo     $tab."</table>\n";
  }
  else {
    echo $tab."warning: not-an-array-or-object given to print_array()<br />\n";
  }
}

function getmicrotime() {
  list($us,$s)=explode(' ',microtime());
  return (float)$us+(float)$s;
}

if ($f_user_search) {
  //the next section adds a search box for the users
  echo $tab.  "<hr />\n";
  echo $tab.  "<form method='get' action='?'>\n";
  //echo $tab."  <input type='hidden' name='language' value='$language' />\n";
  //echo $tab."  <input type='hidden' name='locale'   value='$locale'   />\n";
  //echo $tab."  <input type='text'   name='ty'>Search type</input><br />\n";
  echo $tab.  "  <table>\n";
  echo $tab.  "    <tbody>\n";
  echo $tab.  "      <tr>\n";
  echo $tab.  "        <td>".xu('language for page:')."</td>\n";
  echo $tab.  "        <td>\n";
  echo $tab.  "          <select name='language'>\n";
  foreach ($Alanguage as $i=>$d) {
    echo $tab."            <option value='$i'".($i==$language?" selected='true'":"").">".xu($d)."</option>\n";
  }
  echo $tab.  "          </select>\n";
  echo $tab.  "        </td>\n";
  echo $tab.  "      </tr>\n";
  echo $tab.  "      <tr>\n";
  echo $tab.  "        <td>".xu('which server:')."</td>\n";
  echo $tab.  "        <td>\n";
  echo $tab.  "          <select name='locale'>\n";
  foreach ($Alocale as $i=>$d) {
    echo $tab."            <option value='$i'".($i==$locale?" selected='true'":"").">".xl($d)."</option>\n";
  }
  echo $tab.  "          </select>\n";
  echo $tab.  "        </td>\n";
  echo $tab.  "      </tr>\n";
  echo $tab.  "      <tr>\n";
  echo $tab.  "        <td>".xu('operation:')."</td>\n";
  echo $tab.  "        <td>\n";
  echo $tab.  "          <select name='operation'>\n";
  foreach ($Aoperation as $i=>$d) {
    echo $tab."            <option value='$i'".($i==$operation?" selected='true'":"").">".xu($i)."</option>\n";
  }
  echo $tab.  "          </select>\n";
  echo $tab.  "        </td>\n";
  echo $tab.  "      </tr>\n";
  echo $tab.  "      <tr>\n";
  echo $tab.  "        <td>".xu('product category:')."</td>\n";
  echo $tab.  "        <td>\n";
  echo $tab.  "          <select name='searchindex'>\n";
  foreach ($Asearchindex as $i=>$d) {  //uk and jp not ready yet? 20080730: must be adjusted to the locale again
    echo $tab."            <option value='$d'".($d==$searchindex?" selected='true'":"").">".xl($d)."</option>\n";
  }
  echo $tab.  "          </select>\n";
  echo $tab.  "        </td>\n";
  echo $tab.  "      </tr>\n";
  echo $tab.  "      <tr>\n";
  echo $tab.  "        <td>".xu('search parameter:')."</td>\n";
  echo $tab.  "        <td>\n";
  echo $tab.  "          <select name='searchparameter'>\n";
  foreach ($Aoperation['ItemSearch']['RequiredParameters']['SearchIndex'] as $i=>$d) {
    echo $tab."            <option value='$d'".($d==$searchparameter?" selected='true'":"").">".xu($d)."</option>\n";
  }
  echo $tab.  "          </select>\n";
  echo $tab.  "        </td>\n";
  echo $tab.  "      </tr>\n";
  echo $tab.  "      <tr>\n";
  echo $tab.  "        <td>".xu('search string:')."</td>\n";
  echo $tab.  "        <td><input type='text' name='searchparameterdata' value='$searchparameterdata' /></td>\n";
  echo $tab.  "      </tr>\n";
  echo $tab.  "    </tbody>\n";
  echo $tab.  "  </table>\n";
  echo $tab.  "  <input type='submit' value='Search' />\n";
  echo $tab.  "</form>\n";
  //end of the search box section
}

//phpinfo();

$Amicrotime['show' ][1]=getmicrotime();  //time after showing
$Amicrotime['total'][1]=getmicrotime();  //time at end
//end

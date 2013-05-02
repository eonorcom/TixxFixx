<?php
$website_url= $_GET["URL"];

$curl = curl_init($website_url);
curl_setopt($curl, CURLOPT_AUTOREFERER, true);
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt($curl, CURLOPT_TIMEOUT, 2 );
$html = curl_exec( $curl );
curl_close( $curl );
	
$dom = new DOMDocument;
@$dom->loadHTML($html);

$links = $dom->getElementsByTagName('img');

$web_pic_arr;
$web_src_arr;

$fullPath = explode('/', $website_url);
$DomainBasePath = $fullPath[0] . "//" . $fullPath[2];
$DomainRelativePath = "";

foreach ($fullPath as $path)
{
	$checkExt = strrpos($path, ".");
	if ($checkExt === false || $path == $fullPath[2])
	{
		$DomainRelativePath = $DomainRelativePath . $path . "/";		
	}
}
$DomainRelativePath = substr($DomainRelativePath, 0, -1);

foreach ($links as $link)
{	
	$img_check_error=0;
	$raw_img_url = $link->getAttribute('src');
	$img_final_link = $raw_img_url;

	
	$fullPath = explode('/', $img_final_link);
	$basePath = $fullPath[0] . "//" . $fullPath[2];
	$relativePath = "";
	
	foreach ($fullPath as $path)
	{
		$checkExt = strrpos($path, ".");
		if ($checkExt === false || $path == $fullPath[2])
		{
			$relativePath = $relativePath . $path . "/";		
		}
	}
	$relativePath = substr($relativePath, 0, -1);
	

	$img_url = explode('http://', $raw_img_url);
	$img_check = $img_url[1];
	
	if($img_check==''){
		$img_url = explode('http://', $raw_img_url);
		$img_check = $img_url[1];
		if($img_check!=''){ $img_check_error=1; }
		if($img_check==''){ $img_check_error=2; }
	}
	
	
	switch($img_check_error){
		case 0:
		$web_src_arr[] = $link->getAttribute('src'); break;
		
		case 1:
		$web_src_arr[] = $DomainBasePath.'/'.$link->getAttribute('src'); break;
		
		case 2:
		$web_src_arr[] = $DomainBasePath.'/'.$link->getAttribute('src'); break; 
	}
	
	
}
if ($_GET["Dump"] == "true")
{
	echo "<pre>";
	print_r($web_src_arr);
}
else
{
	echo '' . json_encode($web_src_arr) . '';
}
// you can write a function to process the data however you wish
// here's an example of calling a function that would save the images
// save_images($web_src_arr, $dest, $minWidth, $minHeight);
?>

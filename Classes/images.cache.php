<?php

function cache_image($image_url, $image_id, $image_size, $refresh)
{
	//replace with your cache directory
	$image_path = 'images/cache/';
	$return_path = '';
	$refresh = $_GET["refresh"];
	
	if ($image_url == "" || $refresh == "false") 
	{
		$extension = "jpeg";
		$ck_filename = $image_path.$image_id.".".$extension;
		
		if ($_GET["Dump"] == "true")
		{ 
			echo "Checking: " . $ck_filename . " - " . file_exists($ck_filename) . "<br>";
		}
		
		if (file_exists($ck_filename))
		{
			$return_path = $ck_filename;	
		}
		
		$extension = "jpg";
		$ck_filename = $image_path.$image_id.".".$extension;
		
		if ($_GET["Dump"] == "true")
		{ 
			echo "Checking: " . $ck_filename . " - " . file_exists($ck_filename) . "<br>";
		}
		if (file_exists($ck_filename))
		{
			$return_path = $ck_filename;	
		}
		
		$extension = "gif";
		$ck_filename = $image_path.$image_id.".".$extension;
		
		if ($_GET["Dump"] == "true")
		{ 
			echo "Checking: " . $ck_filename . " - " . file_exists($ck_filename) . "<br>";
		}
		
		if (file_exists($ck_filename))
		{
			$return_path = $ck_filename;	
		}
		
		$extension = "png";
		$ck_filename = $image_path.$image_id.".".$extension;
		
		if ($_GET["Dump"] == "true")
		{ 
			echo "Checking: " . $ck_filename . " - " . file_exists($ck_filename) . "<br>";
		}
		
		if (file_exists($ck_filename))
		{
			$return_path = $ck_filename;	
		}
		
		if ($return_path == "")
		{
			$extension = "png";
			$return_path = $_SERVER['DOCUMENT_ROOT']."/images/noartplaceholder.png";			
		}
		
	}
	
	if ($return_path == "")
	{	
		//get the name of the file
		$exploded_image_url = explode("?",$image_url);
		
		$exploded_image_url = explode("/",$exploded_image_url[0]);
		
		$image_filename = end($exploded_image_url);
		
		$exploded_image_filename = explode(".",$image_filename);
		
		$extension = end($exploded_image_filename);
			
		$local_filename = $image_id.".".$extension;
		
		$ck_filename = $image_path.$image_id.".".$extension;
		
		if ($_GET["Dump"] == "true")
		{ 
			echo "Checking: " . $ck_filename . " - " . file_exists($ck_filename) . "<br>";
			echo "refresh: " . $refresh . "<br>";
		}
		
		if (file_exists($ck_filename) && $refresh == "false") 
		{
			$return_path = $ck_filename;
		}
		else
		{	
		//make sure its an image
			if($extension=="GIF"||$extension=="JPG"||$extension=="PNG"||$extension=="gif"||$extension=="jpg"||$extension=="png"||$extension=="jpeg")
			{
				
				$extension = "jpeg";
				$ck_filename = $image_path.$image_id.".".$extension;
				
				if (file_exists($ck_filename))
				{
					unlink($ck_filename);	
				}
				
				$extension = "jpg";
				$ck_filename = $image_path.$image_id.".".$extension;
				
				if (file_exists($ck_filename))
				{
					unlink($ck_filename);	
				}
				
				$extension = "gif";
				$ck_filename = $image_path.$image_id.".".$extension;
				
				if (file_exists($ck_filename))
				{
					unlink($ck_filename);	
				}
				
				$extension = "png";
				$ck_filename = $image_path.$image_id.".".$extension;
				
				if (file_exists($ck_filename))
				{
					unlink($ck_filename);	
				}
				
				
				//get the remote image
				$image_to_fetch = file_get_contents($image_url);
				list($ver, $retcode, $message) = explode(' ', $http_response_header[0], 3);
				if ($retcode != 200) 
				{
					$extension = "png";
					$return_path = $_SERVER['DOCUMENT_ROOT']."/images/noartplaceholder.png";
				}
				else
				{
					//save it
					$local_image_file = fopen($image_path.$local_filename, 'w+');
					chmod($image_path.$local_filename,0755);
					fwrite($local_image_file, $image_to_fetch);
					fclose($local_image_file);
					
					square_crop($image_path.$local_filename, $image_path.$local_filename, 116);
					
					$return_path = $image_path.$local_filename;
					
				}
			}
		}
	}
	
		
if ($_GET["Dump"] == "true")
{ 
	echo ("<p>Content-type: image/$extension<br>");
	echo ($return_path); 
}
else
{
	header("Content-type: image/$extension");
	readfile($return_path); 
}

}

function square_crop($src_image, $dest_image, $thumb_size = 64, $jpg_quality = 90) {
 
    // Get dimensions of existing image
    $image = getimagesize($src_image);
 
    // Check for valid dimensions
    if( $image[0] <= 0 || $image[1] <= 0 ) return false;
 
    // Determine format from MIME-Type
    $image['format'] = strtolower(preg_replace('/^.*?\//', '', $image['mime']));
 
    // Import image
    switch( $image['format'] ) {
        case 'jpg':
            $image_data = imagecreatefromjpeg($src_image);
        break;
        case 'jpeg':
            $image_data = imagecreatefromjpeg($src_image);
        break;
        case 'png':
            $image_data = imagecreatefrompng($src_image);
        break;
        case 'gif':
            $image_data = imagecreatefromgif($src_image);
        break;
        default:
            // Unsupported format
            return false;
        break;
    }
 
    // Verify import
    if( $image_data == false ) return false;
 
 	
	if ($_GET["Dump"] == "true")
	{ 
		echo "image[0]: " . $image[0] . "<br>";
		echo "image[1]: " . $image[1] . "<br>";
		echo "Check: " . ($image[0] & $image[1]) . "<br>";
	}
 
    // Calculate measurements
    if( $image[0] > $image[1] ) 
	{
 		if ($_GET["Dump"] == "true")
		{ 
			echo "For landscape images<br>";
		}
        // For landscape images
        $x_offset = ($image[0] - $image[1]) / 2;
        $y_offset = 0;
        $square_size = $image[0] - ($x_offset * 2);
    } else {
        // For portrait and square images
		if ($_GET["Dump"] == "true")
		{ 
			echo "For portrait and square images<br>";
		}
        $x_offset = 0;
        $y_offset = ($image[1] - $image[0]) / 2;
        $square_size = $image[1] - ($y_offset * 2);
    }
 
    // Resize and crop
    $canvas = imagecreatetruecolor($thumb_size, $thumb_size);
    if( imagecopyresampled(
        $canvas,
        $image_data,
        0,
        0,
        $x_offset,
        $y_offset,
        $thumb_size,
        $thumb_size,
        $square_size,
        $square_size
    )) {
 
        // Create thumbnail
        switch( strtolower(preg_replace('/^.*\./', '', $dest_image)) ) {
            case 'jpg':
                return imagejpeg($canvas, $dest_image, $jpg_quality);
            case 'jpeg':
                return imagejpeg($canvas, $dest_image, $jpg_quality);
            break;
            case 'jpeg':
                return imagejpeg($canvas, $dest_image, $jpg_quality);
            break;
            case 'png':
                return imagepng($canvas, $dest_image);
            break;
            case 'gif':
                return imagegif($canvas, $dest_image);
            break;
            default:
                // Unsupported format
                return false;
            break;
        }
 
    } else {
        return false;
    }
 
}
 
//usage
cache_image($_GET["url"],$_GET["id"],$_GET["refresh"]);

?>
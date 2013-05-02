<?php include($_SERVER['DOCUMENT_ROOT']."/include/config/dbconfig.php");  ?>
<?php
if(!empty($_POST)){
########   Basic Settings    ########
// Your Root Directory 
$base = $_SERVER['DOCUMENT_ROOT'];
//The Directory Where Files Will Be Uploaded
$dir = "/Classes/images/cache/";
// Your Site URL
$url = "http://tixx";
####################################
$allowded = array("image/bmp","image/pjpeg" , "image/jpeg" , "image/gif" , "image/png" , "image/jpg");
$id = $_POST[id];
$rand = rand( 100 , 20000);
//echo $_FILES[file][type];
//echo $_FILES[file][tmp_name];
        if(empty($_POST[id])){
        echo "You Forgot To Fill the required Feild Please Fix The Error";
                                        }
        elseif(!in_array($_FILES[file][type] , $allowded)){
        echo "Un Expected File Format Only Images Supported";
                                            }
                 elseif($_FILES[file][size] >= 500000){
                 echo "Too Large File!!! Maximum File Size Allowded IS 500 kb!!";
                    }
                                            
                else{
             $filename = $id.$_FILES[file][name];
                $file = $base.$dir.$filename;
                //echo $file;
             $upload = move_uploaded_file($_FILES[file][tmp_name] , $file);
                chmod($file , 0755);
                //echo $_FILES[file][size];
                if($upload){
					
                exit;
                
                
                        }
                }
    }
    
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<body>
<div align="center">
  <form action="images.uploader.php" method="post" enctype="multipart/form-data" name="form1" id="form1">
  <input type="hidden" id="feature-upload-id" name="id" value="1234" />
    <table width="431" border="0" align="center">
      <tr>
        <td><label>Select Your File : </label></td>
        <td><input type="file" name="file" /></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td><input type="submit" name="Submit" value="Submit" /></td>
      </tr>
    </table>
  </form>
</div>
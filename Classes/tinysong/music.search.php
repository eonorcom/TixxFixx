<?php

/**
 * @author https://github.com/amferraz
 * 
 * For API info, refer to:
 * http://tinysong.com/api
 */
require_once 'tinysong.php';

$api_key = '6b77f2bc642db8ec51165202d4fcfb90';

$query = $_GET["search"];

$tinysong = new Tinysong($api_key);

$result = $tinysong
            ->search($query)
            ->execute();


echo '{"results":'.json_encode($result).'}';



//echo "<pre>";
//print_r($result);
//echo "</pre>";
?>
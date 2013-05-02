<?php

require_once 'itunes.php';

$search = new iTunes();

$search->media = 'music';
$search->entity = 'song';


$term = $_GET["term"];

$results = $search->search($term);

echo '{"itunes":'.json_encode($results).'}';


?>
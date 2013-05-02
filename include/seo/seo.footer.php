<?php
$settings['quotes'] = file($_SERVER['DOCUMENT_ROOT']."/include/seo/footer.txt");

$txt = $settings['quotes'][array_rand($settings['quotes'])];

//echo $txt;
?>

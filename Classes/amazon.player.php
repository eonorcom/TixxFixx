<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TixxFixx - MPS Player</title>
</head>

<body style="padding: 0; margin: 0;">

<?php 


$ASIN = $_GET['ASIN'];

echo "<script type='text/javascript'>
var amzn_wdgt={widget:'MP3Clips'};
amzn_wdgt.tag='httpldsmusicc-20';
amzn_wdgt.widgetType='ASINList';
amzn_wdgt.ASIN='$ASIN';
amzn_wdgt.title='TixxFixx  - MP3 Player';
amzn_wdgt.width='336';
amzn_wdgt.height='280';
amzn_wdgt.shuffleTracks='False';
amzn_wdgt.marketPlace='US';
</script>
<script type='text/javascript' src='http://wms.assoc-amazon.com/20070822/US/js/swfobject_1_5.js'></script>
";
?>

</body>
</html>



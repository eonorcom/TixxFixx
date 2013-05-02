

<script type="text/javascript" src="/include/js/ajaxupload.js"></script>       

<form action="/Classes/images.upload.ajax.php" method="post" name="sleeker" id="sleeker" enctype="multipart/form-data">
Feature Image:<br />
    <input type="hidden" id="feature-upload-id" name="id" value="1234" />
    <input type="hidden" name="maxSize" value="9999999999" />
    <input type="hidden" name="maxW" value="592" />
    <input type="hidden" name="returnW" value="116" />
    <input type="hidden" name="fullPath" value="/Classes/images/cache" />
    <input type="hidden" name="relPath" value="images/" />
    <input type="hidden" name="colorR" value="255" />
    <input type="hidden" name="colorG" value="255" />
    <input type="hidden" name="colorB" value="255" />
    <input type="hidden" name="maxH" value="314" />
    <input type="hidden" name="filename" value="filename" />
    <input type="file" name="filename" size="60" onchange="ajaxUpload(this.form,'/Classes/images.upload.ajax.php?filename=name&amp;maxSize=9999999999&amp;maxW=116&amp;fullPath=&amp;relPath=images/&amp;colorR=255&amp;colorG=255&amp;colorB=255&amp;maxH=300','upload_area','File Uploading Please Wait...','&lt;img src=\'images/error.gif\' width=\'16\' height=\'16\' border=\'0\' /&gt; Error in Upload, check settings and path info in source code.'); return false;" />
</form>

<div id="upload_area" style="margin: 10px 0 0 0;"></div>
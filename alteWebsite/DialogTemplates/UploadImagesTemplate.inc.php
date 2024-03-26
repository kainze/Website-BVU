<?php/*
<div id="flashContent"><b>Damit du Buidl hoch lohn konnst muas JavaScript aktiviert und da Flash-Player installiert sei</b></div>

<script type="text/javascript">
    // For version detection, set to min. required Flash Player version, or 0 (or 0.0.0), for no version detection.
    var swfVersionStr = "10.2.0";
    // To use express install, set to playerProductInstall.swf, otherwise the empty string.
    var xiSwfUrlStr = "";
    var flashvars = {};
    flashvars.Url = escape("http://<? echo $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>?action=upload&GID=<? echo $this->GID; ?>");
    var params = {};
    params.quality = "high";
    params.bgcolor = "#ffffff";
    params.allowscriptaccess = "sameDomain";
    params.allowfullscreen = "true";
    var attributes = {};
    attributes.id = "ETHImageUploader";
    attributes.name = "ETHImageUploader";
    attributes.align = "middle";
    swfobject.embedSWF(
        "ETHImageUploader.swf", "flashContent",
        "1064", "555",
        swfVersionStr, xiSwfUrlStr,
        flashvars, params, attributes)
    // JavaScript enabled so display the flashContent div in case it is not replaced with a swf object.
    swfobject.createCSS("#flashContent", "display:block;text-align:left;");
</script>
*/
?>
        <applet code="wjhk.jupload2.JUploadApplet" archive="Layout/wjhk.jupload.jar" alt="" mayscript="true" height="400" width="640">
            <param name="postURL" value="http://<? echo $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI']; ?>?action=upload&GID=<? echo $this->GID; ?>">
            <param name="maxChunkSize" value="500000">
            <param name="uploadPolicy" value="PictureUploadPolicy">
            <param name="nbFilesPerRequest" value="1">
            <!-- Optionnal, see code comments -->
            <param name="maxPicHeight" value="768">
            <!-- Optionnal, see code comments -->
            <param name="maxPicWidth" value="1024">
            <!-- Optionnal, see code comments -->
            <param name="debugLevel" value="1">
            <!-- Optionnal, see code comments -->
            <param name="showLogWindow" value="true">
            <!-- Optionnal, see code comments --> Java 1.5 or higher
            plugin required. </applet>

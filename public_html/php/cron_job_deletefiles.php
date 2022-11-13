<?php

/** define the directory **/
$dir = "/home/u550269871/public_html/tmp_local/";

/*** cycle through all files in the directory ***/
foreach (glob($dir."*") as $file) {

/*** if file is 24 hours (86400 seconds) old then delete it ***/
if(time() - filectime($file) > 2400){
    unlink($file);
    }
}

?>
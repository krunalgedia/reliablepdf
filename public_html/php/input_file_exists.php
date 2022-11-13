<?php
if (isset($_SESSION['user_files'])) {
    $target_files = $_SESSION["user_files"];
    }
else{
    echo '<script type="text/javascript">alert("Please upload atleast one file!");window.history.go(-1);</script>';
    $previous = "javascript:history.go(-1)";
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
    exit;
}

# check number of files
$num_files = count($target_files);
if($num_files==0){
    echo '<script type="text/javascript">alert("Please choose atleast one file!");window.history.go(-1);</script>';
    $uploadOk = 0;
    $previous = "javascript:history.go(-1)";
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
    exit;
}

?>
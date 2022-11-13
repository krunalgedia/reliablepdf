<?php

if(count($file_type_issue)>0){
    ob_clean();
    $str = "Files ".$file_type_issue_list." is not a ".$file_type_ok." and hence can not be converted to ".$file_type_final."\\nPlease click on clear and redo!";
    echo "<script type='text/javascript'>alert('$str');window.history.go(-1);</script>";
    $previous = "javascript:history.go(-1)";
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
    exit;
}

?>  
<?php
// Start the session
session_start();
?>

<?php

$_SESSION["tmp_local"] = "/home/u550269871/public_html/tmp_local/";
$_SESSION["file_loc_delimiter"] = "/" ;
//$_SESSION["user_files"]  = $target_file;

$target_file = $_FILES;
$uploadOk = 1;

# check number of files
$num_files = count($target_file);
if($num_files==0){
    echo 'Please choose atleast one file!';
    $uploadOk = 0;
    exit;
}

$total_size = 0;
$file_type_issue = array();
$file_type_ok = "pdf|png|jpg|jpeg";

//print_r($target_file);

foreach ($target_file as $k => $v) {
	//unset ($target_file[$k]);
	$total_size = $total_size + $target_file[$k]['size'];
    if(!preg_match("/($file_type_ok)/i", $target_file[$k]['type'])){
       array_push($file_type_issue,$target_file[$k]['name']);
    }
}

# file type check
$file_type_issue_list = json_encode($file_type_issue);
if(count($file_type_issue)>0){
    echo "Files $file_type_issue_list is not among $file_type_ok and hence can not be handled by this website. Please click on clear and redo!";
    exit;
}

# file size check
include_once("/home/u550269871/public_html/php/filesize.php");
$inputfilesize = formatSizeUnits("$total_size");
$total_size_possible = 100*1024*1024;
$maxfilesize = formatSizeUnits("$total_size_possible");
if ($total_size > $total_size_possible){
    echo "Total size of uploaded files is $inputfilesize is more than $maxfilesize and hence can not be handled by this website. Please click on clear and redo!";
    exit;
}






//print_r(json_encode($file_type));
/*
// check number of files and limit on them.
$num_files = count($_FILES);
if($num_files>1){
    echo '<script type="text/javascript">alert("Ohh! Please upload only one file at a time")</script>';
    $uploadOk = 0;
    exit;
}
*/

/*
// Allow certain file formats
$inputfileformat = "pdf";
include_once("filesize.php");
$bytes = $_FILES['fileToUpload']['size'];
$inputfilesize = formatSizeUnits("$bytes");
require_once("check_pdf_and_size.php");
if($uploadOk != 1){
    if($filesizeOk !=1){
        echo '<script>alert("Ohh! I wish I could help your file is of size $inputfilesize which is above my threshold of 10MB :(")</script>';
    }
    if ($filetypeOk !=1) {
        echo '<script>alert("Ohh! I wish I could help your file is not a pdf file")</script>'; 
}
    echo '<script>alert("Ohh! I wish I could help you but either this file is not a pdf or its size exceed 10MB")</script>';
    exit;
}
*/

#change keys from file names to integers.
$i = 0;
foreach ($target_file as $k => $v) {
	unset ($target_file[$k]);
	$target_file[$i] = $v;
	$i = $i + 1;
}

$tmp_ext = ".tmp";
#move tmp files and update tmp_names.
foreach ($target_file as $k => $v) {
	$file_name = basename($v['tmp_name']);
	move_uploaded_file($v['tmp_name'],$_SESSION["tmp_local"].$file_name.$tmp_ext);
	$target_file[$k]['tmp_name']=$_SESSION["tmp_local"].$file_name.$tmp_ext;
}

$_SESSION["user_files"]  = $target_file;
print_r($_SESSION["user_files"]);
print("above are uploaded files");

?>
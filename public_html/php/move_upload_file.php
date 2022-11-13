<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php

echo $_SESSION["tmp_local"];
print_r($_SESSION);

//$target_file = $_FILES["fileToUpload"]["tmp_name"];
//echo "$target_file";
print_r($_SESSION["user_files"]);
$num_files = count($_SESSION["user_files"]);
if($num_files>1){
    echo '<script type="text/javascript">alert("Ohh! Please upload only one file at a time")</script>';
    $uploadOk = 0;
    exit;
}
/*
$uploadOk = 1;
$inputFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
$file_mime = mime_content_type("$target_file"); 

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
?>

</body>
</html>
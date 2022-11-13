<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
$target_dir = "../uploads/";
echo is_dir($target_dir);
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

echo "      tmp name          ";
echo $_FILES["fileToUpload"]["tmp_name"]."<br>"; // doesnot print anything
echo "\r\n";
echo "\n       name             ";
echo $_FILES["fileToUpload"]["name"]; // doesnot print anything
echo "\n       target file      "."<br>";
echo "target file is"."<br>"; 
echo $target_file; // this prints "../uploads/". So I think "$_FILES["fileToUpload"]["name"]" is not pointing to anything.


// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
  if($check !== false) {
    echo "/n File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "/n File is not an image.";
    $uploadOk = 0;
  }
}


// Check if file already exists
//if (file_exists($target_file)) {
//  echo "Sorry, file already exists.";
//  $uploadOk = 0;
//}

// Check file size
//if ($_FILES["fileToUpload"]["size"] > 500000) {
//  echo "Sorry, your file is too large.";
//  $uploadOk = 0;
//}

echo "/n Uploaded a file of size ";
echo $_FILES["fileToUpload"]["size"];

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "/n Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "/n Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "/n The file ". htmlspecialchars( basename( $_FILES["fileToUpload"]["name"])). " has been uploaded.";
  } else {
    echo "/n Sorry, there was an error uploading your file.";
  }
}

// Set session variables
$_SESSION["target_file"] = $target_file;
#$_SESSION["favanimal"] = "cat";
#echo "Session variables are set.";

//require 'converter.php';
//return $target_file;
$image = $_SESSION["target_file"];
//$image = "../uploads/Annotation 2019-08-30 211407.png";
//$image = "../uploads/700kb.jpg"; 
echo "image is ", $image."<br>";
require('fpdf.php');
//$image = dirname(__FILE__).DIRECTORY_SEPARATOR.'../images/firefox.png';
$pdf = new FPDF();
$pdf->AddPage();
$pdf->Image($image,20,40,170,170);
ob_end_clean();
$pdf->Output();
?>
</body>
</html>
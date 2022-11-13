<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>


<?php  
// Echo session variables that were set on previous page
//echo "Favorite color is " . $_SESSION["favcolor"] . ".<br>";
//echo "Favorite animal is " . $_SESSION["favanimal"] . ".";

//$image = $_POST['filename'];
//$image = $argv;
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
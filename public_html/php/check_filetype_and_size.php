<?php

if($file_mime == "application/pdf") {
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your pdf file is too large.";
    $uploadOk = 0;
}
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your pdf file is too large.";
    $uploadOk = 0;
}
  if ($_FILES["fileToUpload"]["size"] > 500000) {
    echo "Sorry, your pdf file is too large.";
    $uploadOk = 0;
}
else {
	echo "Oops! you file is not in an excepted format";
}



}



?>
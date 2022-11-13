<?php
if($file_mime == "application/pdf") {
  $filetypeOk = 1;
  if ($_FILES["fileToUpload"]["size"] > 10000000) {
    echo "Sorry, your pdf file is too large.";
    $uploadOk = 0;
    $filesizeOk = 0;
}
  else {
    $filesizeOk = 1;
}
}
else {
    $uploadOk = 0;
	echo "Oops! this is not a pdf file";
    $filetypeOk = 0;
}
?>
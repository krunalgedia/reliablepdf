<?php  
$img = new Imagick('../uploads/Annotation 2020-03-18 015139.png');
$img->setImageFormat('pdf');
$success = $img->writeImage('../uploads/Annotation 2020-03-18 015139.png');
?>
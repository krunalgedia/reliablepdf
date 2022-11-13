<?php
// Start the session
session_start();
?>

<?php

ini_set('zlib.output_compression', 0);
require_once("input_file_exists.php");
$target_files = $_SESSION["user_files"];
$num_files = count($target_files);
$uploadOk = 1;


# Number of input files should be one
require_once("one_input_file_check.php");

require_once("appendstring.php");
$target_file = $target_files; 
$file_type_issue = array();
$file_type_ok = "pdf";
$files_list = "";

//echo '<script type="text/javascript">alert($files_list)</script>';

# file type check
foreach ($target_file as $k => $v) {
	//unset ($target_file[$k]);
	//$total_size = $total_size + $target_file[$k]['size'];
    if(!preg_match("/($file_type_ok)/i", $target_file[$k]['type'])){
        array_push($file_type_issue,$target_file[$k]['name']);
    }
    $files_list = append_string($files_list," -f ",$target_file[$k]['tmp_name'],"\t");
}
$file_type_issue_list = json_encode($file_type_issue);
$file_type_final = "png";
require_once("file_type_check.php");


/*
require_once("appendstring.php");
$gsexec = "C:\\Users\\kbged\\Desktop\\XAMPP\\php\\bin\\gs\\gs9.54.0\\bin\\gswin64c  ";
$bBatch = "-dBATCH";
$dNopause = "-dNOPAUSE";
$sDevice = "-sDEVICE=";
$selectedsDevice = "pdfwrite ";
$sOutputFile = "-sOutputFile=";
$inputfile = $target_file;
$selectedsOutputFile = str_replace(".tmp","%03d.png",$target_file);
$command = append_string($gsexec,$sDevice,$selectedsDevice," -r600 -dDownScaleFactor=3 -sPAPERSIZE=a4 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ",$sOutputFile,$selectedsOutputFile,"\t"," -f ",$inputfile);
exec($command);

gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=temp.pdf pdf1.pdf pdf2.pdf
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

$noziprequired = False;

if($num_files==1){
    $im = new Imagick();
    $im->pingImage($target_files[0]['tmp_name']);
    $numberOfPages = $im->getNumberImages();
    //echo '<script type="text/javascript">alert("Please choose one file at a time!")</script>';
    //$uploadOk = 0;
    //exit;
    $noziprequired = ($numberOfPages==1);
}
echo "$noziprequired";


/*
$im = new Imagick();
$im->pingImage("$target_file");
$numberOfPages = $im->getNumberImages();

$noziprequired = ($numberOfPages==1);
*/

//$noziprequired = False;


require_once("appendstring.php");
$gsexec = "/usr/bin/gs  ";
$sDevice = "-sDEVICE=";
$selectedsDevice = "png16m ";
$sOutputFile = "-sOutputFile=";
$inputfile = $target_file;
$selectedsOutputFile = str_replace(".tmp","%03d.png",$_SESSION["user_files"][0]["tmp_name"]);
//$command = append_string($gsexec,$sDevice,$selectedsDevice," -r600 -dDownScaleFactor=3 -sPAPERSIZE=a4 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ",$sOutputFile,$selectedsOutputFile,"\t",$inputfile);
$command = append_string($gsexec,$sDevice,$selectedsDevice," -r600 -dDownScaleFactor=3 -sPAPERSIZE=a4 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ",$sOutputFile,$selectedsOutputFile,"\t",$files_list);
exec($command);
echo "$command";


//echo "<script> document.getElementById('pdf_to_png_submit').value = 'done!';</script>";
/*
echo '<script type="text/javascript">window.history.go(-1);</script>';
$previous = "javascript:history.go(-1)";
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
    */
//echo "<script> document.getElementById('pdf_to_png_submit').value = 'done!';</script>";*/


if($noziprequired){
    $sendfolder = array_values(glob(str_replace("%03d","*",$selectedsOutputFile)))[0];
    header('Content-type: image/png');
    
}


$finalDir = "/home/u550269871/public_html/tmp_local/";

if(!$noziprequired){
    $zipfolderlocation = str_replace(".tmp",".zip",$_SESSION["user_files"][0]["tmp_name"]);
    $filescreated = glob(str_replace("%03d","*",$selectedsOutputFile));
    $foldername = str_replace(".zip","",basename($zipfolderlocation));
    mkdir($finalDir.$foldername);
    foreach ($filescreated as $filename) {
        $basename = basename($filename);
        rename($filename,$finalDir.$foldername."/".$basename);
    }
    
    
    // Enter the name of directory
    $pathdir = $finalDir.$foldername."/"; 
    // Enter the name to creating zipped directory
    $zipcreated = "$foldername".".zip";  
    // Create new zip class
    $zip = new ZipArchive;
   
    if($zip -> open($zipcreated, ZipArchive::CREATE ) === TRUE) {
      
        // Store the path into the variable
        $dir = opendir($pathdir);
       
        while($file = readdir($dir)) {
            if(is_file($pathdir.$file)) {
                $zip -> addFile($pathdir.$file, $file);
            }
        }
        $zip ->close();
    }
    //rename("$zipcreated",$finalDir.$zipcreated);
    copy("$zipcreated",$finalDir.$zipcreated);
    //unlink($zipcreated);
    
    $zip = new ZipArchive();
    $zip->open($finalDir.$zipcreated);
    echo "total number of files in zip are: ";
    $count = $zip->count();
    echo "$count "."<br>";
    echo "size of the zip file is :" ;
    echo filesize($finalDir.$zipcreated);


    $sendfolder = "$zipcreated";
    #$sendfolder = "C:/Users/kbged/Desktop/XAMPP/tmp/$zipcreated";
    header('Content-type: application/zip');
    

}


//header('Content-Description: File Transfer');
header("Content-Disposition: attachment; filename=$sendfolder");
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
$size = filesize($sendfolder);
header('Content-Length: ' . filesize("$sendfolder"));
echo "$sendfolder";
ob_clean();
readfile($sendfolder);


if($noziprequired){
    unlink(array_values(glob(str_replace("%03d","*",$selectedsOutputFile)))[0]);
    //unlink($target_files[0]['tmp_name']);
    foreach ($target_file as $k => $v) {
        unlink($target_file[$k]['tmp_name']);
    }
}
if(!$noziprequired){
    unlink($zipcreated);
    unlink($finalDir.$zipcreated);
    $delFolder = str_replace(".zip","",$finalDir.$zipcreated); 
    //unlink($target_files[0]['tmp_name']);
    array_map('unlink', glob("$delFolder/*.*"));
    rmdir($delFolder);
    foreach ($target_file as $k => $v) {
        unlink($target_file[$k]['tmp_name']);
    }
}

unset($_SESSION['user_files']);

$_SESSION['user_files'] = new stdClass();


/*
echo '<script type="text/javascript">window.history.go(-1)</script>';
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}

echo '<script type="text/javascript">alert("Done!");window.history.go(-1);</script>';
$previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
exit;

*/

/*
echo '<script type="text/javascript">window.location.reload();</script>';
$previous = "javascript:history.go(-1)";
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
exit;

echo '<script type="text/javascript">window.location.reload();</script>';
*/
?>
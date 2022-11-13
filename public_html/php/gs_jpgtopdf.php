<?php
// Start the session
session_start();
?>


<?php
require_once("input_file_exists.php");
$target_files = $_SESSION["user_files"];
$num_files = count($target_files);
$uploadOk = 1;

# Number of input files should be one
require_once("one_input_file_check.php");

require_once("appendstring.php");
$target_file = $target_files; 
$file_type_issue = array();
$file_type_ok = "jpg or jpeg";
$file_type_ok_syntax = str_replace(" or ","||",$file_type_ok);
$files_list = "";

# file type check

foreach ($target_file as $k => $v) {
    if(!preg_match("/($file_type_ok_syntax)/i", $target_file[$k]['type'])){
       array_push($file_type_issue,$target_file[$k]['name']);
    }
    $files_list = append_string($files_list," -c (",$target_file[$k]['tmp_name'],")","\t");
}

$file_type_issue_list = json_encode($file_type_issue);
$file_type_final = "pdf";
require_once("file_type_check.php");


$noziprequired = True;

require_once("appendstring.php");
$gsexec = "/usr/bin/gs   ";
$dNosafer = " -dNOSAFER ";
$sDevice = "-sDEVICE=";
$selectedsDevice = "pdfwrite ";
$sOutputFile = "-sOutputFile=";
$inputfile = $target_files[0]['tmp_name'];
$selectedsOutputFile = str_replace(".tmp",".pdf",$_SESSION["user_files"][0]["tmp_name"]);
//$command = append_string($gsexec,$sDevice,$selectedsDevice," -r600 -dDownScaleFactor=3 -sPAPERSIZE=a4 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ",$sOutputFile,$selectedsOutputFile,"\t",$inputfile);
//$command = append_string($gsexec,$sDevice,$selectedsDevice," -r600 -dDownScaleFactor=3 -sPAPERSIZE=a4 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ",$sOutputFile,$selectedsOutputFile,"\t",$files_list);
$command = append_string($gsexec, $dNosafer ,$sDevice,$selectedsDevice, "-o " , '"',$selectedsOutputFile,'"', " ", '"',"/home/u550269871/public_html/viewjpeg.ps",'"'," -c ",'"(',$inputfile,")"," << /PageSize 2 index viewJPEGgetsize 2 array astore >> setpagedevice viewJPEG",'"');
exec($command);
echo "$command";
//exit;

//C:\Users\kbged\Desktop\XAMPP\php\bin\gs\gs9.54.0\bin\gswin64c -dNOSAFER -sDEVICE=pdfwrite -o "C:/Users/kbged/Desktop/XAMPP/tmp_local/php7E64%03d.pdf" "C:\Users\kbged\Desktop\XAMPP\php\bin\gs\gs9.54.0\lib\viewjpeg.ps -c "(C:/Users/kbged/Desktop/XAMPP/tmp_local/php7E64.tmp) << /PageSize 2 index viewJPEGgetsize 2 array astore >> setpagedevice viewJPEG" 
// C:\Users\kbged\Desktop\XAMPP\php\bin\gs\gs9.54.0\bin\gswin64c -dNOSAFER -sDEVICE=pdfwrite -o "C:\Users\kbged\Downloads\php48D4.pdf" "C:\Users\kbged\Desktop\XAMPP\php\bin\gs\gs9.54.0\lib\viewjpeg.ps"  -c "(C:\\Users\\kbged\\Pictures\\group_image.jpg)  << /PageSize 2 index viewJPEGgetsize 2 array astore >> setpagedevice viewJPEG"
//gswin64c -dNOSAFER -sDEVICE=pdfwrite -o output.pdf "C:\\Users\\kbged\\Desktop\\XAMPP\\php\\bin\\gs\\gs9.54.0\\lib\\viewjpeg.ps" -c (input.jpg) viewJPEG
//gs -dNOSAFER -sDEVICE=pdfwrite -o foo.pdf /usr/local/share/ghostscript/8.71/lib/viewjpeg.ps  -c \(my.jpg\) viewJPEG


//gswin64c.exe  -sDEVICE=jpeg  -sOutputFile=page-%03d.jpg  -r100x100 
#-dJPEGQ=95
if($noziprequired){
    //$sendfolder = array_values(glob(str_replace("%03d","*",$selectedsOutputFile)))[0];
    $sendfolder = $selectedsOutputFile;
    header('Content-type: application/pdf');
    
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




?>

<?php
// Start the session
session_start();
?>

<?php
$first_page=1;
$last_page=1;
if (isset($_POST['first_page']) && isset($_POST["last_page"])) {
    $first_page=$_POST['first_page'];
    $last_page=$_POST["last_page"];
    }
else{
    echo '<script type="text/javascript">alert("Please upload atleast one file!");window.history.go(-1);</script>';
    $previous = "javascript:history.go(-1)";
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
    exit;
}

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

# file type check
foreach ($target_file as $k => $v) {
    if(!preg_match("/($file_type_ok)/i", $target_file[$k]['type'])){
        array_push($file_type_issue,$target_file[$k]['name']);
    }
    $files_list = append_string($files_list," ",$target_file[$k]['tmp_name'],"\t");
}
$file_type_issue_list = json_encode($file_type_issue);
$file_type_final = "pdf";
require_once("file_type_check.php");


$noziprequired = True;

require_once("appendstring.php");
$gsexec = "/usr/bin/gs   ";
$dBatch = " -dBATCH ";
$dNopause = " -dNOPAUSE ";
$dSafer = " -dSAFER ";
$q       = " -q ";
$sDevice = "-sDEVICE=";
$selectedsDevice = "pdfwrite ";
$sOutputFile = " -sOutputFile=";
$dFirstpage = " -dFirstPage=";
$dLastpage = " -dLastPage=";
$inputfile = $files_list;
$selectedsOutputFile = str_replace(".tmp",".pdf",$_SESSION["user_files"][0]["tmp_name"]);
#gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -dPDFSETTINGS=/prepress -sOutputFile=temp.pdf pdf1.pdf pdf2.pdf
#gs -sDEVICE=pdfwrite -dNOPAUSE -dBATCH -dSAFER -dFirstPage=3 -dLastPage=5 -sOutputFile=out.pdf in.pdf
$command = append_string($gsexec,$dBatch,$dNopause,$dSafer,$sDevice,$selectedsDevice,$dFirstpage,$first_page,$dLastpage,$last_page,$sOutputFile,$selectedsOutputFile," ",$inputfile);
exec($command);
echo "$command";

if($noziprequired){
    $sendfolder = array_values(glob(str_replace("%03d","*",$selectedsOutputFile)))[0];
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



echo '<script type="text/javascript">window.location.reload();</script>';
?>
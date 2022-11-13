<?php

$target_files = $_SESSION["user_files"];
$uploadOk = 1;
//$inputFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
//$file_mime = mime_content_type("$target_file"); 

print_r($_SESSION["user_files"]);
$num_files = count($target_files);
/*
# check number of files
$num_files = count($target_files);
if($num_files>1){
    echo '<script type="text/javascript">alert("Please choose one file at a time!")</script>';
    $uploadOk = 0;
    exit;
}
*/
/*
$target_file = $_SESSION["user_files"][0]["tmp_name"];
//$total_size = 0;
*/
require_once("appendstring.php");
$target_file = $target_files; 
$file_type_issue = array();
$file_type_ok = "pdf";
$files_list = "";

foreach ($target_file as $k => $v) {
	//unset ($target_file[$k]);
	//$total_size = $total_size + $target_file[$k]['size'];
    if(!preg_match("/($file_type_ok)/i", $target_file[$k]['type'])){
       array_push($file_type_issue,$target_file[$k]['name']);
    }
    $files_list = append_string($files_list," -f ",$target_file[$k]['tmp_name'],"\t");
}
//echo '<script type="text/javascript">alert($files_list)</script>';


# file type check
$file_type_issue_list = json_encode($file_type_issue);
if(count($file_type_issue)>0){
    echo '<script type="text/javascript">alert("Files $file_type_issue_list is not among $file_type_ok and hence can not be handled by this website. Please click on clear and redo!")</script>';
    exit;
}

 

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
    print("image location is  ");
    print($target_files[0]['tmp_name']);
    $dot = ".";
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
//$gsexec = "C:\\Users\\kbged\\Desktop\\XAMPP\\php\\bin\\gs\\gs9.54.0\\bin\\gswin64c  ";
$gsexec = "/usr/bin/gs ";
$sDevice = "-sDEVICE=";
$selectedsDevice = "png16m ";
$sOutputFile = "-sOutputFile=";
$inputfile = $target_file;
$selectedsOutputFile = str_replace(".tmp","%03d.png",$_SESSION["user_files"][0]["tmp_name"]);
//$command = append_string($gsexec,$sDevice,$selectedsDevice," -r600 -dDownScaleFactor=3 -sPAPERSIZE=a4 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ",$sOutputFile,$selectedsOutputFile,"\t",$inputfile);
$command = append_string($gsexec,$sDevice,$selectedsDevice," -r600 -dDownScaleFactor=3 -sPAPERSIZE=a4 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ",$sOutputFile,$selectedsOutputFile,"\t",$files_list);
exec($command);
echo "$command";

$finalDir = "/home/u550269871/public_html/tmp_local/";
#$finalDir = "/tmp/";

if($noziprequired){
    $sendfolder = array_values(glob(str_replace("%03d","*",$selectedsOutputFile)))[0];
    header('Content-type: image/png');
}
if(!$noziprequired){
    $zipfolderlocation = str_replace(".tmp",".zip",$_SESSION["user_files"][0]["tmp_name"]);
    $filescreated = glob(str_replace("%03d","*",$selectedsOutputFile));
    $foldername = str_replace(".zip","",basename($zipfolderlocation));
    //mkdir("/tmp/$foldername");
    mkdir($finalDir.$foldername);
    var_dump(is_file("/tmp")) . "\n";
    var_dump(file_exists($finalDir.$foldername)) . "\n";
    echo($finalDir.$foldername);
    echo("direcctory empty made");
    
    foreach ($filescreated as $filename) {
        $basename = basename($filename);
        var_dump(file_exists("$filename")) . "\n";
        //rename($filename,"/tmp/$foldername/$basename");
        echo($finalDir.$foldername."/".$basename);
        rename($filename,$finalDir.$foldername."/".$basename);
        //var_dump(is_file("/tmp/$foldername/$basename")) . "\n";
        var_dump(file_exists("/tmp/$foldername/$basename")) . "\n";
        echo("---------------------");
        
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
    copy("$zipcreated",$finalDir.$zipcreated);

    $zip = new ZipArchive();
    $zip->open($finalDir.$zipcreated);
    echo "total number of files in zip are: ";
    $count = $zip->count();
    echo "$count "."<br>";
    echo "size of the zip file is :" ;
    echo filesize($finalDir.$zipcreated);
    

    $sendfolder = "$zipcreated";
    
    header('Content-type: application/zip');

}

//header('Content-Description: File Transfer');
header("Content-Disposition: attachment; filename=$sendfolder");
//header('Expires: 0');
//header('Cache-Control: must-revalidate');
//header('Pragma: public');
$size = filesize($sendfolder);
//header('Content-Length: ' . filesize("$sendfolder"));
ob_clean();
readfile($sendfolder);
#readfile("$zipcreated");
/*
if($noziprequired){
    unlink(array_values(glob(str_replace("%03d","*",$selectedsOutputFile)))[0]);
}
if(!$noziprequired){
    // remove zip file is exists in temp path
    unlink($zipcreated);
    foreach ($filescreated as $filename) {
        unlink("/tmp/$foldername/$basename");
    }
}
*/
?>
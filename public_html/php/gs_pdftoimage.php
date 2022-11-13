<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
apache_setenv('no-gzip', 1);

$target_files = $_SESSION["user_files"];
$uploadOk = 1;

#echo $_SESSION["user_files"];
$num_files = count($target_files);

# check number of files
$num_files = count($target_files);
if($num_files==0){
    echo '<script type="text/javascript">alert("Please choose atleast one file!")</script>';
    $uploadOk = 0;
    exit;
}


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
$gsexec = "C:\\Users\\kbged\\Desktop\\XAMPP\\php\\bin\\gs\\gs9.54.0\\bin\\gswin64c  ";
$sDevice = "-sDEVICE=";
$selectedsDevice = "png16m ";
$sOutputFile = "-sOutputFile=";
$inputfile = $target_file;
$selectedsOutputFile = str_replace(".tmp","%03d.png",$_SESSION["user_files"][0]["tmp_name"]);
//$command = append_string($gsexec,$sDevice,$selectedsDevice," -r600 -dDownScaleFactor=3 -sPAPERSIZE=a4 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ",$sOutputFile,$selectedsOutputFile,"\t",$inputfile);
$command = append_string($gsexec,$sDevice,$selectedsDevice," -r600 -dDownScaleFactor=3 -sPAPERSIZE=a4 -dTextAlphaBits=4 -dGraphicsAlphaBits=4 ",$sOutputFile,$selectedsOutputFile,"\t",$files_list);
exec($command);
echo "$command";

if($noziprequired){
    $sendfolder = array_values(glob(str_replace("%03d","*",$selectedsOutputFile)))[0];
    header('Content-type: image/png');
}
if(!$noziprequired){
    $zipfolderlocation = str_replace(".tmp",".zip",$_SESSION["user_files"][0]["tmp_name"]);
    $filescreated = glob(str_replace("%03d","*",$selectedsOutputFile));
    $foldername = str_replace(".zip","",basename($zipfolderlocation));
    mkdir("C:\\Users\\kbged\\Desktop\\XAMPP\\tmp\\$foldername");
    foreach ($filescreated as $filename) {
        $basename = basename($filename);
        rename($filename,"C:/Users/kbged/Desktop/XAMPP/tmp/$foldername/$basename");
    }

    // Enter the name of directory
    $pathdir = "C:/Users/kbged/Desktop/XAMPP/tmp/$foldername/"; 
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
    copy("$zipcreated","C:/Users/kbged/Desktop/XAMPP/tmp/$zipcreated");

    $zip = new ZipArchive();
    $zip->open("C:/Users/kbged/Desktop/XAMPP/tmp/$zipcreated");
    echo "total number of files in zip are: ";
    $count = $zip->count();
    echo "$count "."<br>";
    echo "size of the zip file is :" ;
    echo filesize("C:/Users/kbged/Desktop/XAMPP/tmp/$zipcreated");


    $sendfolder = "$zipcreated";
    #$sendfolder = "C:/Users/kbged/Desktop/XAMPP/tmp/$zipcreated";
    header('Content-type: application/zip');

}

header('Content-Description: File Transfer');
header("Content-Disposition: attachment; filename=$sendfolder");
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
$size = filesize($sendfolder);
header('Content-Length: ' . filesize("$sendfolder"));
ob_clean();
readfile($sendfolder);
#readfile("$zipcreated");

if($noziprequired){
    unlink(array_values(glob(str_replace("%03d","*",$selectedsOutputFile)))[0]);
}
if(!$noziprequired){
    // remove zip file is exists in temp path
    unlink($zipcreated);
    foreach ($filescreated as $filename) {
        unlink("C:/Users/kbged/Desktop/XAMPP/tmp/$foldername/$basename");
    }
}

?>
</body>
</html>
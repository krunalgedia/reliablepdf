<?php
  // The global $_POST variable allows you to access the data sent with the POST method by name
  // To access the data sent with the GET method, you can use $_GET
  $name = $_POST['customer_name'];
  $mail  = $_POST['email_address'];
  $msg  = htmlspecialchars($_POST['comments']);
  //echo 'your data is saved! Thank you!';
  $texttosave = $name.' '. $mail.' '. $msg;
  //echo $texttosave;

  $datafile = fopen('../customer_feedback.txt','a');
  fwrite($datafile,$texttosave);
  fclose($datafile); 

   // read/ write mode
   //$file_pointer = fopen("../test.txt", 'r+')
   //or die("File does not exist");
   //$res = fgets($file_pointer);
   //echo $res;
   //fclose($file_pointer);
   echo "<script type='text/javascript'>alert('Thank you for the feedback! \\nHave a nice day!');window.history.go(-1);</script>";
    $previous = "javascript:history.go(-1)";
    if(isset($_SERVER['HTTP_REFERER'])) {
        $previous = $_SERVER['HTTP_REFERER'];
    }
    
?>

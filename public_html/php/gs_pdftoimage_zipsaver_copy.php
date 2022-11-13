<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html>
<body>

<?php
//apache_setenv('no-gzip', 1);
ini_set('zlib.output_compression', 0);

include("gs_pdftoimage_copy.php");
include("zipsaver.php");


?>
</body>
</html>
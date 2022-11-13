<?php
system( "which gs > /dev/null", $retval );
if ( $retval == 0 ) {
    // run gs
}
echo $retval;
//if (shell_exec("gs --version") >= $min_gs_version) {
    // run gs
//}
echo shell_exec("gs --version");
system("gs --version",$version);
echo $version;
system("which gs", $whichgs);
echo $whichgs;
?>
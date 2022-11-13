<?php
// function to append a string 
function append_string () {
      
    // Using Concatenation assignment
    // operator (.=)
    //$str1 .=$str2;
    $numargs = func_num_args();
    echo "number fo arguments is :";
    echo "$numargs <br>";
    $arg_list = func_get_args();
    echo "$arg_list[0]";
    $command = "";
    for ($x = 0; $x < $numargs; $x++) {
        echo "The number is: $arg_list[$x] <br>";
        $command .=$arg_list[$x];
    } 
    echo "final command is ";
    //echo $arg_list;
    echo "$command <br>";
         

    // Returning the result 
    return $command;
}
?>
<?php
$output=null;
$retval=null;
//exec('./soma', $output, $retval);
$last_line = system('./soma', $retval);
//echo "Returned with status $retval and output:\n";
//print_r($output);
?>


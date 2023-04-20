<?php
// this name is route
$temp= "include/templets/"; // templets directory
$css= "frontend/css/"; // css directory
$js = "frontend/css/"; // js directory
$arab = "include/languages/";
$eng = "include/languages/" ;
$func = "include/functions/";



include $eng . "eng.php" ;  // لازم تخلي ملف اللغه اول حاجه
include $func . "func.php";
include $temp . "header.php" ; 
include $arab . "arab.php" ; 
include "connect.php" ; // connected file

if (!isset($noNav)) {
include $temp . "navbar.php";
    
}


?>
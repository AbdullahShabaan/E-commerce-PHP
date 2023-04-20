<?php
// this name is route
$temp= "admin/include/templets/"; // templets directory
//$css= "admin/frontend/css/"; // css directory
//$js = "admin/frontend/css/"; // js directory
$arab = "admin/include/languages/";
$eng = "admin/include/languages/" ;
$func = "admin/include/functions/";



include $eng . "eng.php" ;  // لازم تخلي ملف اللغه اول حاجه
include $func . "func.php";
include "header.php" ; 
include $arab . "arab.php" ; 
include "connect.php" ; // connected file

if (!isset($noNav)) {
include  "navbar.php";
    
}


?>
<?php

$do = "";

if (isset($_GET['do'])) {
    $do = $_GET['do'];
    
}else {
    $do = "manage";
}

if ($do == "manage"){
    
        echo "<a href='page.php?do=manage'>Manage Page</a>" . "<br>";
        echo "<a href='page.php?do=add'>Add Page</a>" . "<br> ";
        echo "<a href='page.php?do=delete'>Delete Page</a>" . "<br>";


    
} elseif ($do == "add") {
        echo "welcome to the add page";
    
} elseif ($do == "delete"){
    
        echo "welcome to the delete page";

}







?>
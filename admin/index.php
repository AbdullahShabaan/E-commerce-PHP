<?php 
session_start();
$noNav = "";
$pageTitle = "login";
//if (isset($_SESSION["user"])) {
//    header ("location: dashboard.php");
//}
include "init.php" ; 

//include "frontend/css/backend.css" ; 

?>

<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
$user = $_POST["user"];
$pass = $_POST["pass"];
$hashedPass = sha1($pass);

    $stmt= $conn->prepare("SELECT  user_id , user_name , password from users where user_name = ? AND password = ? AND group_id = 1 LIMIT 1");
    $stmt->execute(array($user , $hashedPass));
    $row= $stmt->fetch();
    $count = $stmt->rowCount();
    
        if ($count > 0 ) {
   
            $_SESSION["user"] = $user ;
            $_SESSION["id"] = $row["user_id"];
            header("location: dashboard.php");
            exit();
        }
    
    

}




?>


<form class ="login" method="POST" action="">
    <h3 class=text-center>ِAdmin Login</h3>

    <input class="form-control" type="text" placeholder="enter username" autocomplete="off" name="user">
    <input class="form-control" type="password" placeholder="enter password" autocomplete="off" name="pass">
    <input class="btn btn-primary btn-block" type="submit" value="Login">
    


</form>






<?php
//include $temp . "footer.php" ;
?>
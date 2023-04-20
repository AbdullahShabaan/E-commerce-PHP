<?php
session_start();
$pageTitle = "login";
if (isset ($_SESSION["user2"])){
    header ("location: profile.php");
}
include "init.php";
$do = null ;

if (isset($_GET["do"])) {
    $do = $_GET["do"] ;
}else {
    $do = "login";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
        if (isset ($_POST["login"])) {
    $username = $_POST["username"];
    $pass = $_POST["pass"];
    $hash_pass = sha1($pass);
    
    $errors = array ();
    if (empty ($username)) {
        $errors[] = "<div class='alert alert-warning'>empty username!</div>";
    
    }
    
    if (empty ($pass)) {
        $errors[] = "<div class='alert alert-warning'>empty password!</div>";
    
    }
    
    foreach($errors as $error) {
        echo $error ;
    }
    
    
        if (empty($errors)) {

            $stmt = $conn->prepare("SELECT * from users where user_name = ? AND password = ? ");
            $stmt->execute(array($username , $hash_pass));
            $row = $stmt->fetch();
            $count = $stmt->rowCount();
            
                if ($count > 0) {
                    $_SESSION["user2"] = $username ;
                    $_SESSION["id2"] = $row["user_id"] ;
                    header("location: profile.php");
                    exit();
                } else {
                    echo "<div class='alert alert-danger'>this username not exist!</div>";
                }
    
        }
        }else {

            
        
        $errors = array ();
            
            
            if (isset ($_POST["name"])) {
                $filter_name = filter_var ($_POST["name"] , FILTER_SANITIZE_STRING , FILTER_NULL_ON_FAILURE) ;

                if (strlen ($filter_name ) <= 3 or strlen ($filter_name) > 10) {
                    $errors [] = "<div class='alert alert-warning'>username must be more than 3 char & less than 10 char</div>";
                }
         
            }
            
            
            if (isset ($_POST["pass1"]) && isset ($_POST["pass2"])) {
                
                if (empty ($_POST["pass1"]) and empty ($_POST["pass2"])) {
                     $errors[] ="<div class='alert alert-warning'> password field is empty! </div>"; 
                } 
                $pass1 = sha1 ($_POST["pass1"] ); 
                $pass2 = sha1 ($_POST["pass2"] ); 
              
              
                    if ($pass1 !==  $pass2) {
                        
                        
                       $errors[] ="<div class='alert alert-warning'> password not match! </div>"; 
                    }
               
            
            
            }
            
            if (isset ($_POST["mail"])) {
                
                $mail = filter_var ($_POST["mail"] , FILTER_SANITIZE_EMAIL) ;
                
                if (filter_var ($mail , FILTER_VALIDATE_EMAIL) != true) {
                     $errors[] ="<div class='alert alert-warning'> wrong e-mail </div>";
                }
                
                
                
            }
            
            
            if (isset ($_POST["full_name"])) {
                
                if (empty($_POST["full_name"])) {
                    $errors[] ="<div class='alert alert-warning'> full name field is empty ! </div>";
                    
                }else {
                    
                    $full_name = filter_var ($_POST["full_name"] , FILTER_SANITIZE_STRING) ; 
                    
                    if (strlen ($full_name) > 50) {
                        $errors[] ="<div class='alert alert-warning'> full name must be shorter than that! </div>";
                    }
                    
                    
                }
                
                
                
            }

    
            
           if (!empty($errors)) { 
            foreach ($errors as $error) {
                echo $error . "<br>";
            }
           }else {
               
               $check = check_user ("user_name" , "users" , $filter_name );
               if ($check > 0) {
                  
                    echo "<div class='alert alert-danger'> username already exist! please try another name </div>";
                   
                   
               } else {
                  
                  $stmt = $conn->prepare ("insert into users  (user_name , password , e_mail , full_name) values (:user_namez , :passwordz , :e_mailz , :full_namez)" ) ;
                   $stmt->execute(array("user_namez" => $filter_name , "passwordz" => $pass1 , "e_mailz" => $mail , "full_namez" => $full_name ));
                   $countsSuccess = $stmt->rowCount() ;
                   if ($countsSuccess > 0 ) {
                           echo "<div class='alert alert-success'> record success , you will be redirected to login page </div>";
                       header ("refresh: 5 ; url=login.php?do=login");
                   }
                   
                   
               }
           }
            
        
        }
}




if ($do == "login") {?>


 <div class="container" >
        <div class="row justify-content-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header text-center">
                        <h4>Login</h4>
                    </div>
                    <div class="card-body">
                        <form action ="" method="POST">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Username</label>
                                <input type="text" class="form-control" id="exampleInputEmail1" aria- placeholder="enter your username" name="username">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputPassword1" class="form-label">password</label>
                                <input type="password" class="form-control" id="exampleInputPassword1" placeholder="enter your password" name ="pass"> 
                            </div>
                            <div class="d-flex justify-content-between">
                            
                                <a  href="login.php?do=signup">signup?</a>
                            </div>
                            <button type="submit" class="btn btn-danger float-right mt-3 w-40" name ="login">Enter</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



<!--signup-->
<?php } elseif ($do == "signup") {?>

<div class="container mt-4">
<form class="row g-3" method="POST" action= "">
  <div class="col-md-6">
    <label for="inputEmail4" class="form-label">Username</label>
    <input type="text" name = "name" class="form-control" id="inputEmail4">
  </div>
  <div class="col-md-6">
    <label  class="form-label">Password</label>
    <input type="password" class="form-control" name = "pass1">
  </div>
    <div class="col-md-6">
    <label  class="form-label">Confirm Password</label>
    <input type="password" class="form-control" name = "pass2">
  </div>
  <div class="col-6">
    <label for="email" class="form-label">E-mail</label>
    <input name ="mail" type="text" class="form-control"  placeholder="enter a valid e-mail">
  </div>
  <div class="col-6">
    <label for="inputAddress2" class="form-label">Full Name</label>
    <input name = "full_name" type="text" class="form-control"  placeholder="enter your full name">
  </div>

  <div class="col-12 g-4">
    <button type="submit" class="btn btn-danger mt-5" name="signup">Sign in</button>
  </div>
</form>

</div>
       <?php }


//include $temp . "footer.php";

?>
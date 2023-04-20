<?php
// manage member page 


session_start() ;
$pageTitle= "Members Manage";
if (isset($_SESSION["user"])) {
    include ("init.php") ;
    
    
    $do = "" ;
    
        if (isset($_GET["do"])) {
            
            $do = $_GET["do"] ;
            
        } else {
            $do =  "manage";
            

        } 
    
    if ($do == "manage") {
        
        $var = null ;
        
        if (isset($_GET["page"]) and $_GET['page'] == "pending") {
            
            $var = "AND reg_status = 0";
            
        }
    
    $stmt = $conn->prepare("select * from users where group_id != 1 $var order by user_id DESC");
    $stmt->execute();
    
    $info = $stmt->fetchAll();
    
    if (!empty($info)) {
     ?>
        
            <h1 class="text-center">Manage Page</h1>
            <div class="container" id= "member">
                
                <table class="table">
  <thead class="thead-dark">
    <tr>
      <th >ID</th>
      <th >Username</th>
      <th >E-mail</th>
      <th >Full Name</th>
      <th >registerd date</th>
      <th >control</th>
    </tr>
  </thead>
                    
                    <?php
                    
                        foreach($info as $newinfo) {
                            echo "<tr>" ;
                                echo "<td>". $newinfo["user_id"]."</td>";
                                echo "<td>". $newinfo["user_name"]."</td>";
                                echo "<td>". $newinfo["e_mail"]."</td>";
                                echo "<td>". $newinfo["full_name"]."</td>";
                                echo "<td>". $newinfo["registerd_date"]."</td>";
                                    echo "<td>" ;
                            
                            if ($newinfo["reg_status"] != 0 ) {
                            echo "<a href='members.php?do=edit&user_id=". $newinfo['user_id'] ."' class='btn btn-primary m-1'><i class='fa fa-edit'></i>Edit</a>";  
                            
                            echo "<a href='members.php?do=delete&user_id=". $newinfo['user_id'] ."' class='btn btn-danger m-1'><i class='fa fa-close '></i>Delete</a>"  ;
                            
                            }
                            
                                if ($newinfo["reg_status"] == 0 ) {
                                    
                                    echo "<a href='members.php?do=activate&user_id=". $newinfo['user_id'] ."' class='btn btn-success m-1'><i class='fa fa-check'></i>Activate</a>"  ;
                                    
                                      echo "<a href='members.php?do=delete&user_id=". $newinfo['user_id'] ."' class='btn btn-danger m-1'><i class='fa fa-close'></i>Refuse</a>"  ;
                                      echo "<a href='members.php?do=edit&user_id=". $newinfo['user_id'] ."' class='btn btn-primary m-1'><i class='fa fa-edit'></i>Edit</a>";
                            
                                    
                                    
                                    
                                }
                                
                            
                            echo  "</td>";
                            echo "</tr>";
                        }
     
    }else {
                echo "<div class='alert alert-warning'>there's no members yet</div>";

    }
                    ?>

</table>


        
                <a href='members.php?do=add' class='btn btn-primary '><i class='fa fa-plus'></i>ADD NEW MEMBER</a>
           </div>
            
        
        
   <?php



}
    
    elseif ($do == "add") {?>
            
            
        
        
        
        
        <h1 class="text-center" id= "member">add new member</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=insert" method="POST">
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="username" class="form-control"  autocomplete="off"  />
							</div>
						</div>
						<!-- End Username Field -->
						<!-- Start Password Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10 col-md-6">
								
								<input type="password" name="password"  class="form-control" autocomplete="new-password"  />
							</div>
						</div>
						<!-- End Password Field -->
						<!-- Start Email Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10 col-md-6">
								<input type="email" name="email"   class="form-control"  />
							</div>
						</div>
						<!-- End Email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="full"   class="form-control"  />
							</div>
						</div>
						<!-- End Full Name Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>

        
        
        
        
        
        
        <?php 
        
    }elseif($do == "insert") {
            
        echo "<h1 class='text-center'>Inserted infromation</h1>";
                
                
                 echo "<div class='container'>" ;
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                    $passs = $_POST["password"];
                    $pass = sha1($passs);
                    $user = $_POST["username"] ;
                    $e_mail = $_POST["email"] ;
                    $full_name = $_POST["full"] ;
                    
                    
              
                              
                    // check empty forms 
                    
                $error = array ()    ;
                    
                    if (strlen($user) < 3 or strlen($user) > 17 or empty ($user))  {
                        $error[]=  "<div class='alert alert-danger'>username field must be <strong>between</strong> 3 , 17 char and can't be <strong>empty</strong>!</div>";
                       
                    }
                    
                    if (empty ($e_mail)) {
                        $error[]=  "<div class='alert alert-danger'>e-mail field is <strong>empty</strong>!</div>";
                        
                    }
                    
                     if (empty ($passs)) {
                        $error[]=  "<div class='alert alert-danger'>password field is <strong>empty</strong>!</div>";
                        
                    }
                    
                    if (empty ($full_name)){
                        $error[]=  "<div class='alert alert-danger'>full name field is <strong>empty</strong>!</div>";
                    }
                
                foreach ($error as $new) {
                    echo $new ;
                }
                    
                    if (empty($error) ) {
                        
                       $var = check_user("user_name" , "users" , $user );   
                        
                        if ($var > 0 ) {
                            $getMessage = "<div class='alert alert-danger'>username already exists</div>";
                            redirect2($getMessage , 3 , "back");
                            echo " <a href='members.php?do=add' class='btn btn-primary '>Back</a> ";

                        }else {
                            $stmt =$conn->prepare("insert into users (user_name , e_mail , full_name , password , reg_status ) VALUES (:iuser , :iemail , :ifull , :ipass , 1)" );
                        $stmt->execute(array( 'iuser' => $user , 'iemail' => $e_mail , 'ifull' => $full_name , 'ipass' => $pass ));
                                
                     $getMessage = " <div class='alert alert-success'>" . $stmt->rowCount() . " member inserted successfully</div>";
                            
                        redirect2 ($getMessage , 3 , "back");
                            
                        echo "<a href=members.php?do=add  class='btn btn-default btn-lg'>add onther member</a>";
        
                        echo " <a href='members.php?do=add' class='btn btn-primary '>Back</a> ";
                        } 
                        
                        
                    }
                echo "</div>";
                        
                    }else {
                    
                      $getMessage = "<div class='alert alert-danger'>you can't browse this page directly</div>";        
                    redirect2($getMessage , 5 , "back") ;    
        
                } 
                    
                    
                }   
    
                
            



        
       
        
    
        

    
elseif ($do == "edit") {
                // everything with edit coding here
//                echo "welcome to edit page your ID is " . $_SESSION['id'] ;
                
          
                
                // for security 
                $userID = (isset($_GET["user_id"]) && is_numeric($_GET["user_id"])) ? $_GET["user_id"] : 0 ;
        
        
        
                // for security     
                
                
    $stmt= $conn->prepare("SELECT * from users where user_id = ? LIMIT 1");
    $stmt->execute(array($userID));
    $row= $stmt->fetch();
    $count = $stmt->rowCount();

                
                    echo '<div class="card">
                    <div class="card-body">
                    <h5 class="card-title">'."Name : ".$row["user_name"].'</h5>
                    <p class="card-text">' ."ID : ". $userID .'</p>
                    </div>
                    </div>' ;
    
        
        
if ($count > 0) {
    
    

        
        ?>
                 
                
<?php 
    if ($row["group_id"] == 1 ) {
  echo '<h1 class="text-center" >Edit Admin </h1>' ;
    } else {
        echo '<h1 class="text-center" >Edit Member </h1>';
    }
    ?>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="user_id" value="<?php echo $userID ?>" />
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Username</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="username" class="form-control" value="<?php echo $row["user_name"]?>" autocomplete="off"  />
							</div>
						</div>
						<!-- End Username Field -->
						<!-- Start Password Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Password</label>
							<div class="col-sm-10 col-md-6">
								<input type="hidden" name="oldpassword" value="<?php echo $row["password"]?>" />
								<input type="password" name="newpassword" class="form-control" autocomplete="new-password" placeholder="Leave Blank If You Dont Want To Change" />
							</div>
						</div>
						<!-- End Password Field -->
						<!-- Start Email Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Email</label>
							<div class="col-sm-10 col-md-6">
								<input type="email" name="email" value="<?php echo $row["e_mail"]?>" class="form-control"  />
							</div>
						</div>
						<!-- End Email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Full Name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="full" value="<?php echo $row["full_name"]?>" class="form-control"  />
							</div>
						</div>
						<!-- End Full Name Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>

<?php } else {
    
    
   $getMessage = "<div class='alert alert-danger'>there is no user with this ID ! try again</div>";
    
    redirect2 ($getMessage , 3 , "back") ;
} 
            } elseif ($do == "Update"){
                echo "<h1 class='text-center'>Update Page</h1>";
                
                
                 echo "<div class='container'>" ;
                
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
                    $id = $_POST["user_id"] ;
                    $user = $_POST["username"] ;
                    $e_mail = $_POST["email"] ;
                    $full_name = $_POST["full"] ;
                    
                    
                $pass = "";               
                    if (empty($_POST["newpassword"])) {
                        $pass = $_POST["oldpassword"];
                    } else {
                        $pass = sha1($_POST["newpassword"]);
                    }
                   
                    
                    // check empty forms 
                    
                $error = array ()    ;
                    
                    if (strlen($user) < 3 or strlen($user) > 17 or empty ($user))  {
                        $error[]=  "<div class='alert alert-danger'>username field must be <strong>between</strong> 3 , 17 char and can't be <strong>empty</strong>!</div>";
                       
                    }
                    
                    if (empty ($e_mail)) {
                        $error[]=  "<div class='alert alert-danger'>e-mail field is <strong>empty</strong>!</div>";
                        
                    }
                    
                    if (empty ($full_name)){
                        $error[]=  "<div class='alert alert-danger'>full name field is <strong>empty</strong>!</div>";
                    }
                
                foreach ($error as $new) {
                    echo $new ;
                }
                    
                    if (empty($error)) {
                        
                        
                      $stmt33 = $conn->prepare("SELECT * from users where user_name =? AND user_id != ? ")  ;
                      $stmt33->execute(array($user , $id));
                      $count33 = $stmt33->rowCount();
                        
                        
                        if ($count33 > 0) {
                         
                            
                            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>warning:</strong> The name you have chosen is already taken, please choose a different name .
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                            </div>' ;
                            
                           echo  '<button class="btn btn-secondary" onclick="window.history.back()">
                           <i class="fa fa-arrow-left"></i> Go back
                           </button> ' ;
                                
                                
                        } else {
                    
                 $stmt =$conn->prepare("UPDATE users SET user_name =? , e_mail =? , full_name  =? , password =? WHERE user_id = ?");
                 $stmt->execute(array($user , $e_mail , $full_name , $pass , $id));
                 $getMessage = " <div class='alert alert-success'>" . $stmt->rowCount() . " record updated</div>";
                 redirect2 ($getMessage);
                        }
                        
                        
                        
                    
                        
                    }
                    
                    
                }else {
                    $getMessage = "<div class='alert alert-danger'>sorry! you can't enter to this page</div>";
                    redirect2($getMessage);
                }
                
                echo "</div>";
                
            } elseif ($do == "delete") {
        
            
        
        
            if (isset($_GET["user_id"]) and is_numeric($_GET["user_id"])) {
                $userid = $_GET["user_id"];
                
                $stmt= $conn->prepare("delete from users where user_id =?") ;
                $stmt->execute(array($userid)) ;
                
                if ($stmt->rowCount() > 0) {
             $getMessage = " <div class='alert alert-success'>" . $stmt->rowCount() . " record deleted</div>";
                    redirect2 ($getMessage , 5,"back");
                }else {
              $getMessage = " <div class='alert alert-danger'>" . $stmt->rowCount() . " user not exist </div>";
                    redirect2 ($getMessage , 5 ,"back");

            }
        
                
                
                
            } 
        
        
            }elseif($do == "activate") {
    
    if (isset($_GET["user_id"]) && is_numeric($_GET["user_id"])) {
        
        $useridd = $_GET["user_id"];
        
        $stmt= $conn->prepare("UPDATE users SET reg_status = 1 where user_id=?");
        $stmt->execute(array($useridd));
        $count = $stmt->rowCount();
            if ($count > 0 ) {
               
                
                $getMessage = " <div class='alert alert-success'>" . $stmt->rowCount() . " member activate successfully</div>";
                    redirect2 ($getMessage);
                
            }
    }
    
    
}


 
}
    
    else {
    
    header("location: index.php");
    
}
    
    include $temp . "footer.php" ; 

?>
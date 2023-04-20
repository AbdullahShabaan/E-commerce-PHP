<?php 
session_start();
if (isset($_SESSION["user"])) {
include ("init.php") ;

$do = null ;

if (isset ($_GET["do"])) {
    
    $do = $_GET["do"];
    
} else {
    
    $do = "manage";
}

if ($do == "manage") {
    
    $stmt = $conn->prepare("SELECT comments.* , item.item_name as Item_name , users.user_name as user_name from comments inner JOIN item on comments.item_id = item.item_id inner JOIN users on comments.user_id = users.user_id order by c_id DESC ;
");
    $stmt->execute();
    $row = $stmt->fetchAll();
    
    if (!empty($row)) {
    ?>

            <h1 class="text-center">Manage Comments Page</h1>
            <div class="container" id= "member">
                
                <table class="table">
  <thead class="thead-dark">
    <tr>
      <th >ID</th>
      <th >Comment</th>
      <th >Item Name</th>
      <th >User Name</th>
      <th >Comments Date</th>
      <th >Control</th>
    </tr>
  </thead>
                    
                    <?php
                    
                        foreach($row as $newinfo) {
                            echo "<tr>" ;
                                echo "<td>". $newinfo["c_id"]."</td>";
                                echo "<td>". $newinfo["comment"]."</td>";
                                echo "<td>". $newinfo["Item_name"]."</td>";
                                echo "<td>". $newinfo["user_name"]."</td>";
                                echo "<td>". $newinfo["comment_date"]."</td>";
                            
                            echo "<td>" ;
                            echo "<a href='comments.php?do=edit&com_id=". $newinfo['c_id'] ."' class='btn btn-primary m-1'><i class='fa fa-edit'></i>Edit</a>";  
                            
                            echo "<a href='comments.php?do=delete&com_id=". $newinfo['c_id'] ."' class='btn btn-danger m-1'><i class='fa fa-close'></i>Delete</a>"  ;
//                            
//                            if ($newinfo["status"] == 0) {
//                                
//                                 echo "<a href='comments.php?do=delete&com_id=". $newinfo['c_id'] ."' class='btn btn-info'><i class='fa fa-check'></i> Approve</a>"  ;
//                            echo  "</td>";
//                                
//                            }
                             
                            echo  "</td>";
                            
                            
                            echo "</tr>";
                        }
     
    }else {
                echo "<div class='alert alert-warning'>there's no comments </div>";

    }
                    ?>

</table>


        
      

<?php
    
    
    
    
    
    
    
    
    
}elseif ($do == "edit") {
    
    if (isset ($_GET["com_id"]) && is_numeric($_GET["com_id"])) {
        
        $com_id = $_GET["com_id"] ;
        
        $stmt= $conn->prepare("select * from comments where c_id = ?") ;
        $stmt->execute(array($com_id));
        $row = $stmt->fetch();
        $count = $stmt->rowCount();
        
        if ($count > 0 ) {
            
            
            ?>
                
                
                
                
             
  <h1 class="text-center" id= "member">Edit Comment</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=Update" method="POST">
						<input type="hidden" name="com_id" value="<?php echo $com_id ?>" />
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Comment</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="comment" class="form-control" value="<?php echo $row["comment"]?>" autocomplete="off"  />
							</div>
						</div>
						<!-- End Username Field -->
						<!-- Start Password Field -->
            
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">member name</label>
							<div class="col-sm-10 col-md-6">
								<select class = "form-control" name="member">
                                
                                <?php 
        
        
                                    $stmt1 = $conn->prepare("SELECT * from users")    ;
                                    $stmt1->execute();
                                    $gets = $stmt1->fetchAll();
                                    foreach ($gets as $gets2) {
                                        echo "<option value='".$gets2['user_id']. "'" ; 
                                        if ($row['user_id'] == $gets2['user_id']) {
                                            echo 'selected' ;
                                        }
                                        echo ">" . $gets2['user_name']. "</option>";
                                    }
                                    
                                    
                                    
                                ?>
                                    
                                </select>
                                
							</div>
                                          
						</div>
                        
<!--                        -->
                        
                    <div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Item name</label>
							<div class="col-sm-10 col-md-6">
								<select class = "form-control" name="item">
                                
                                <?php 
        
        
                                    $stmt1 = $conn->prepare("SELECT * from item")    ;
                                    $stmt1->execute();
                                    $gets = $stmt1->fetchAll();
                                    foreach ($gets as $gets2) {
                                        echo "<option value='".$gets2['item_id']. "'" ; 
                                        if ($row['item_id'] == $gets2['item_id']) {
                                            echo 'selected' ;
                                        }
                                        echo ">" . $gets2['item_name']. "</option>";
                                    }
                                    
                                    
                                    
                                ?>
                                    
                                </select>
                                
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
   
                
                
                
                
                
                
                
                
            <?php
            
            
            
            
            
            
        }
        
        
        
    }else {
        echo "there is no comment with this id!";
    }
    
}elseif ($do == "Update"){
    
    if ($_SERVER ["REQUEST_METHOD"] == "POST") {
    
    if (isset ($_POST["com_id"]) && is_numeric ($_POST["com_id"])) {
        
        $com_id = $_POST["com_id"];
        $comment = $_POST["comment"];
        $item = $_POST["item"];
        $member = $_POST["member"] ;
        
        $check = check_user ("c_id" , "comments" , $com_id );
        
        if ($check > 0) {
           
            
            $stmt = $conn->prepare("update comments set comment =?  , item_id =? , user_id =? where c_id =?") ;
            $stmt->execute(array($comment ,$item , $member , $com_id)) ;
            $count = $stmt->rowCount ();
            
                if ($count > 0 ){
                    
                $getMessage = "<div class='alert alert-success'> Comment Updated successfully</div>";
               redirect2 ($getMessage , 3 , "back") ;

                } else {
                    
                 $getMessage = "<div class='alert alert-warning'> same information updated!</div>";
               redirect2 ($getMessage , 3 , "back") ;
                }
            
            
            
            
        }else {
            $getMessage = "not exist!";
            redirect2 ($getMessage , 3 , "back") ;
        }
    
    }
    
    
}else {
        $getMessage = "<div class='alert alert-warning'> you can't browse this page !</div>";
               redirect2 ($getMessage , 3 , "back") ;  
        
    }
    
    
    
    
    
    
    
}elseif ($do == "delete") {
    
    if (isset ($_GET["com_id"]) && is_numeric ($_GET["com_id"])){
        $comId = $_GET["com_id"];
        
        
        $stmt= $conn->prepare("select * from comments where c_id =?");
        $stmt->execute(array($comId));
        $count = $stmt->rowCount();
        
            if ($count > 0 ) {
                
                $stmt2 = $conn->prepare("delete from comments where c_id = ?");
                $stmt2->execute(array($comId)) ;
                $count2 = $stmt2->rowCount();
                        if ($count2 > 0) {
                             $getMessage = "<div class='alert alert-success'> <h3>comment deleted successfully</h3> </div>";
                             redirect2 ($getMessage , 3 , "back") ; 
                        }
                
            }else {
                  $getMessage = "<div class='alert alert-warning'> comment alerady not exist !</div>";
               redirect2 ($getMessage , 3 , "back") ; 
            }
        
        
    }
    
}
















include $temp . "footer.php";
    
} else {
    
    echo "you can't browse this page";
    header ("location index.php");
    
}
?>
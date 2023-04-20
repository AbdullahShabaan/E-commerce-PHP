<?php
ob_start();
session_start();

$pageTitle = "Items";

if (isset($_SESSION["user"])) {
    
   include ("init.php");
    
    $do = null ;
    
    if (isset ($_GET["do"])) {
        $do = $_GET["do"];
    }else {
        $do = "manage";
    }
    
    if ($do == "manage") {

         $stmt = $conn->prepare("select item.* , categories.name as category_name , users.user_name as Member_name from item inner join categories on categories.id = item.cat_id inner join users on users.user_id = item.member_id order by item_id DESC;
");
    $stmt->execute();
    
    $info = $stmt->fetchAll();
    
    if (!empty($info)) {
     ?>
        
            <h1 class="text-center">Manage item Page</h1>
            <div class="container" id= "member">
                
                <table class="table">
  <thead class="thead-dark">
    <tr>
      <th >Item name</th>
      <th >Image</th>
      <th >Description</th>
      <th >Price</th>
      <th >Made in</th>
      <th >Status</th>
      <th >Rating</th>
      <th >Date</th>
      <th >Category Name</th>
      <th >Member Name</th>
      <th >Control</th>
    </tr>
  </thead>
                    
                    <?php
                    
                        foreach($info as $newinfo) {
                            echo "<tr>" ;
                                echo "<td>". $newinfo["item_name"]."</td>";
                                echo "<td>". $newinfo["image"]."</td>";
                                echo "<td>". $newinfo["item_description"]."</td>";
                                echo "<td>". $newinfo["price"]."</td>";
                                echo "<td>". $newinfo["made_in"]."</td>";
                                echo "<td>". $newinfo["status"]."</td>";
                                echo "<td>". $newinfo["rating"]."</td>";
                                echo "<td>". $newinfo["dates"]."</td>";
                                echo "<td>". $newinfo["category_name"]."</td>";
                                echo "<td>". $newinfo["Member_name"]."</td>";
                            echo "<td>" ;
                            
                          
                         
                                
                               echo "<a href='items.php?do=edit&item_id=" . $newinfo["item_id"]. "' class='btn btn-primary m-1' ><i class='fa fa-edit'></i>Edit</a>";  
                            
                            echo "<a href='items.php?do=delete&item_id=" . $newinfo["item_id"]. "' class='btn btn-danger m-1'><i class='fa fa-close'></i> Delete</a>"  ; 
                              
                                
                        
                            if ($newinfo["approve"] == 0 ) {
                            
                                 echo "<a href='items.php?do=approve&item_id=" . $newinfo["item_id"]. "' class='btn btn-success ml-4'><i class='fa fa-check'></i> Confirm</a>"  ;
                          
                            }
                            
                                    
//                                    echo "<a href='members.php?do=activate&user_id=". $newinfo['user_id'] ."' class='btn btn-success'><i class='fa fa-check'></i>Activate</a>"  ;
//                                    
//                                      echo "<a href='members.php?do=delete&user_id=". $newinfo['user_id'] ."' class='btn btn-danger'><i class='fa fa-close'></i>Refuse</a>"  ;
//                                      echo "<a href='members.php?do=edit&user_id=". $newinfo['user_id'] ."' class='btn btn-primary'><i class='fa fa-edit'></i>Edit</a>";
                            
                                    
                                    
                                    
                                
                                
                            
                            echo  "</td>";
                            echo "</tr>";
                        }
     
    }else {
        echo "<div class='alert alert-warning'>there is no items inserted yet</div>";
    }
                    ?>

</table>


        
                <a href='items.php?do=add' class='btn btn-primary '><i class='fa fa-plus'></i>ADD NEW ITEM</a>
           </div>
            
        
        
   <?php
    }elseif ($do == "add") {?>
        
          
        
        
        <h1 class="text-center" id= "member">Add New Item</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=insert" method="POST">
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Item name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" placeholder ="name of the item" name="name" class="form-control"  autocomplete="off"  />
							</div>
						</div>
                        
<!--                        -->
                        
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Descreption</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" placeholder ="description of the item" name="desc" class="form-control"  autocomplete="off"  />
							</div>
						</div>
                        
<!--                        -->
                        
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">price</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" placeholder ="item price" name="price" class="form-control"  autocomplete="off"  />
							</div>
						</div>
                        
<!--                        -->
                        
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">country made</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="country" class="form-control"  autocomplete="off" 
                                       placeholder ="country"/>
							</div>
						</div>
                        
<!--                        -->
                        
                         	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">status</label>
							<div class="col-sm-10 col-md-6">
								<select class = "form-control" name="status">
                                
                                    <option value="0">...</option>
                                    <option value="1">new</option>
                                    <option value="2">like new</option>
                                    <option value="3">used</option>
                                    
                                </select>
                                
							</div>
                                
<!--                                -->
                                
                                
                       
                                
						</div>
                        
<!--                        -->
                        
                        
                         	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">select member name</label>
							<div class="col-sm-10 col-md-6">
								<select class = "form-control" name="member">
                                
                                    <option value="0">...</option>
                                <?php 
        
        
                                    $stmt1 = $conn->prepare("SELECT * from users")    ;
                                    $stmt1->execute();
                                    $gets = $stmt1->fetchAll();
                                    foreach ($gets as $gets2) {
                                        echo "<option value='".$gets2['user_id']."'> " . $gets2['user_name']. "</option>";
                                    }
                                    
                                    
                                    
                                ?>
                                    
                                </select>
                                
							</div>
                                
<!--                                -->
                                
                                
                       
                                
						</div>
                        
                        
                        
<!--                        -->
                        
                        
                        
                         	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">select category</label>
							<div class="col-sm-10 col-md-6">
								<select class = "form-control" name="cat_member">
                                
                                    <option value="0">...</option>
                                <?php 
        
        
                                    $stmt1 = $conn->prepare("SELECT * from categories")    ;
                                    $stmt1->execute();
                                    $gets = $stmt1->fetchAll();
                                    foreach ($gets as $gets2) {
                                        echo "<option value='".$gets2['id']."'> " . $gets2['name']. "</option>";
                                    }
                                    
                                    
                                    
                                ?>
                                    
                                </select>
                                
							</div>
                                
<!--                                -->
                                
                                
                       
                                
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
        
    }elseif ($do == "insert") {
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
            $iname = $_POST["name"];
            $idesc = $_POST["desc"];
            $iprice = $_POST["price"];
            $icountry = $_POST["country"];
            $istatus = $_POST["status"];
            $member = $_POST["member"];
            $cat_member = $_POST["cat_member"];
            
            
            
            $errors = array ();
            
            if (empty ($iname) or strlen($iname) < 3 or strlen($iname) > 17) {
                $errors[]= "<div class='alert alert-danger'>Sorry! name field required</div>";
//                redirect2 ($errors[1] , 2 , "back");
            }
            
            // 
            
             if (empty ($idesc) ) {
                $errors[]= "<div class='alert alert-danger'>Sorry! description field required</div>";
//                header ("location: HTTP_REFERER");
            }
            
            //
            
             if (empty ($iprice) ) {
                $errors[]= "<div class='alert alert-danger'>Sorry! price field required</div>";
//                header ("location: HTTP_REFERER");
            }
            
            //
            
             if (empty ($icountry) ) {
                $errors[]= "<div class='alert alert-danger'>Sorry! country field required</div>";
//                header ("location: HTTP_REFERER");
            }
            
            //
            
             if (empty ($istatus) ) {
                $errors[]= "<div class='alert alert-danger'>Sorry! status field required</div>";
//                header ("location: HTTP_REFERER");
            }
            
            //
            
             if (empty ($member) ) {
                $errors[]= "<div class='alert alert-danger'>Sorry! status field required</div>";
//                header ("location: HTTP_REFERER");
            }
            
            //
            
             if (empty ($cat_member) ) {
                $errors[]= "<div class='alert alert-danger'>Sorry! status field required</div>";
//                header ("location: HTTP_REFERER");
            }
            
            foreach($errors as $newErrors) {
                echo $newErrors . "<br>";
            }
            
            
            if (empty($errors)) {
                
                $stmt= $conn->prepare("select item_name from item where item_name =?");
                $stmt->execute(array($iname));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                if ($count > 0 ) {
                    $error = "<div class='alert alert-danger'>Item already exist!</div>" ;
                    redirect2 ($error , 5 , "back");
                    
                    
                    
                }else {
                    
                    $stmt2 = $conn->prepare("insert into item (item_name , item_description , price , made_in , status , cat_id , member_id ) values (:item_namee , :item_descriptionn , :pricee , :made_inn , :statuss , :cat_idd , :member_idd )");
                    $stmt2->execute(array("item_namee" => $iname , "item_descriptionn" => $idesc , "pricee" => $iprice , "made_inn" => $icountry , "statuss" => $istatus , "cat_idd" => $cat_member , "member_idd" => $member ));
                    $row2 = $stmt2->fetch();
                    $mssg = "<div class='alert alert-success'><i class='fa-solid fa-check'></i> item updated successfully</div>";
                    redirect2 ($mssg , 5 , "items.php?do=insert");
                    
                }
                
                
            }

        
        }else {
            $error = "<div class='alert alert-danger'>You can't browse this page!</div>";
            redirect2 ($error , 5 );
        }
        
        
        
    }elseif ($do == "edit"){
        $itemID = null ;
        
        if (isset($_GET["item_id"]) && is_numeric($_GET["item_id"])) {
            $itemID = $_GET["item_id"] ;
        }
        
        
        if (!empty ($itemID)) {
            
            $stmt = $conn->prepare("SELECT * from item where item_id=?") ;
            $stmt->execute(array($itemID));
            $data = $stmt->fetch();
            $count = $stmt->rowCount();
            
                if ($count > 0 ) {?>
                    
      
        <h1 class="text-center" id= "member">Edit Item</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=update" method="POST">
                        	<input type="hidden" name="item_id" value="<?php echo $itemID ?>" />
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Item name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" value = "<?php echo $data ["item_name"] ?>" name="name" class="form-control"  autocomplete="off"  />
							</div>
						</div>
                        
<!--                        -->
                        
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Descreption</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" value = "<?php echo $data ["item_description"] ?>"  name="desc" class="form-control"  autocomplete="off"  />
							</div>
						</div>
                        
<!--                        -->
                        
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">price</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" value = "<?php echo $data ["price"] ?>"  name="price" class="form-control"  autocomplete="off"  />
							</div>
						</div>
                        
<!--                        -->
                        
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">country made</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="country" class="form-control"  autocomplete="off" 
                                       value = "<?php echo $data ["made_in"] ?>" />
							</div>
						</div>
                        
<!--                        -->
                        
                         	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">status</label>
							<div class="col-sm-10 col-md-6">
								<select class = "form-control" name="status"
                                        >
                                
                                    <option value="1" <?php if ($data['status'] == 1) { echo 'selected' ; }  ?> >new</option>
                                    <option value="2" <?php if ($data['status'] == 2) { echo 'selected' ; }  ?> >like new</option>
                                    <option value="3" <?php if ($data['status'] == 1) { echo 'selected' ; }  ?> >used</option>
                                    
                                </select>
                                
							</div>
                                
<!--                                -->
                                
                                
                       
                                
						</div>
                        
<!--                        -->
                        
                        
                         	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">select member name</label>
							<div class="col-sm-10 col-md-6">
								<select class = "form-control" name="member">
                                
                                <?php 
        
        
                                    $stmt1 = $conn->prepare("SELECT * from users")    ;
                                    $stmt1->execute();
                                    $gets = $stmt1->fetchAll();
                                    foreach ($gets as $gets2) {
                                        echo "<option value='".$gets2['user_id']. "'" ; 
                                        if ($data['member_id'] == $gets2['user_id']) {
                                            echo 'selected' ;
                                        }
                                        echo ">" . $gets2['user_name']. "</option>";
                                    }
                                    
                                    
                                    
                                ?>
                                    
                                </select>
                                
							</div>
                                
<!--                                -->
                                
                                
                       
                                
						</div>
                        
                        
                        
<!--                        -->
                        
                        
                        
                         	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">select category</label>
							<div class="col-sm-10 col-md-6">
								<select class = "form-control" name="cat_member">
                                
                                <?php 
        
        
                                    $stmt1 = $conn->prepare("SELECT * from categories")    ;
                                    $stmt1->execute();
                                    $gets = $stmt1->fetchAll();
                                    foreach ($gets as $gets2) {
                                        echo "<option value= '" .$gets2['id']."' " ; 
                                        if ($data['cat_id'] == $gets2['id']){
                                            echo "selected";
                                        }
                                        echo ">" . $gets2['name']. "</option>";
                                    }
                                    
                                    
                                    
                                ?>
                                    
                                </select>
                                
							</div>
                                
<!--                                -->
                                
                                
                       
                                
						</div>
                        			<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Save" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form> <?php
                                  
                     $stmt = $conn->prepare("SELECT comments.* 
                     , users.user_name as user_name 
                     from comments 
                     inner JOIN users 
                     on comments.user_id = users.user_id
                     where item_id = ?  
                     
                     ");
                                  
                                  
    $stmt->execute(array($itemID));
    $row = $stmt->fetchAll();
    
    if (!empty ($row)) {
    ?>

            <h3 class="new text-center ">Comments on [ <?php echo $data["item_name"]?> ] item</h3>
            <div class="container" id= "member">
                
                <table class="table">
  <thead class="thead-dark">
    <tr>
      <th >ID</th>
      <th >Comment</th>
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
                                echo "<td>". $newinfo["user_name"]."</td>";
                                echo "<td>". $newinfo["comment_date"]."</td>";
                            
                            echo "<td>" ;
                            echo "<a href='comments.php?do=edit&com_id=". $newinfo['c_id'] ."' class='btn btn-primary'><i class='fa fa-edit'></i>Edit</a>";  
                            
                            echo "<a href='comments.php?do=delete&com_id=". $newinfo['c_id'] ."' class='btn btn-danger'><i class='fa fa-close'></i>Delete</a>"  ;
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
     
                        
                    ?>

</table>
				</div>
                   <?php }
                    
                    
                    
               } else {
                     $error = "<div class='alert alert-warning'>there is no category with this id</div>";
            redirect2 ($error , 5 , "back");
                }
               
            
        }
        
        
        
    }elseif ($do == "update") {
        
        if ($_SERVER["REQUEST_METHOD"] == "POST"){
            
            $item_id = $_POST["item_id"] ;
            $item_name = $_POST["name"] ;
            $item_desc = $_POST["desc"] ;
            $item_price = $_POST["price"] ;
            $item_country = $_POST["country"] ;
            $item_status = $_POST["status"] ;
            $item_member = $_POST["member"] ;
            $item_category = $_POST["cat_member"] ;
            
            $errors = array (); 
            
            if (empty ($item_name )) {
               $errors []=   "<div class='alert alert-danger'> field name required</div>" ;
//                redirect2 ($error , 5 , "back");
            }
            
              if (empty ($item_desc )) {
               $errors []=   "<div class='alert alert-danger'> field description required</div>" ;
//                redirect2 ($error , 5 , "back");
            }
            
              if (empty ($item_price )) {
               $errors []=  "<div class='alert alert-danger'> field price required</div>" ;
//                redirect2 ($error , 5 , "back");
            }
            
              if (empty ($item_country )) {
               $errors []=   "<div class='alert alert-danger'> field country required</div>" ;
//                redirect2 ($error , 5 , "back");
            }
            
        
            foreach ($errors as $newErrors) {
                echo $newErrors ;
                $url = $_SERVER["HTTP_REFERER"];
                $seconds = 5 ;
            header("refresh:5;url=$url");
            }
            
            
            if (empty ($errors)) {
            
            $stmt = $conn->prepare("update item set item_name =? , item_description =? , price =? , made_in =? , status =?  , member_id =? , cat_id =? where item_id =? ");
            $stmt->execute(array($item_name , $item_desc , $item_price , $item_country , $item_status , $item_member , $item_category , $item_id));
            $count = $stmt->rowCount();
            
            if ($count > 0 ) {
                
                echo " <div class='alert alert-success'>updated success </div>";
                          $url = $_SERVER["HTTP_REFERER"];
                $seconds = 5 ;
            header("refresh:5;url=$url");
            }
            
            
            
            }
            
            
            
            
            
            
        } else {
            echo "you can't browse this page!";
        }
        
        
        
    }elseif ($do == "delete"){
        $idd = null ;
        
        if (isset ($_GET["item_id"])) {
            $idd = $_GET["item_id"] ;   
        }
        
        
        if (!empty($idd)) {
            $stmt = $conn->prepare("delete from item where item_id =?");
            $stmt->execute(array($idd));
            $count = $stmt->rowCount();
            
            if ($count > 0 ) {
                            $msg =  '<div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Well done!</h4>
                            <p>'. $count .' item deleted successfully from your website ..</p>
                            <hr>
                            </div>' ;
                            redirect2 ($msg , 5 , "back") ;
            }else {
                echo "<div class='alert alert-danger'>record failed!</div>";
            }
            
        }else {
              echo "<div class='alert alert-danger'>there is no item with this id!</div>";

        }
        
        
        
    }elseif ($do == "approve") {
        
        $item = null ;
        
        if (isset($_GET["item_id"]) && is_numeric($_GET["item_id"])) {
            $item = $_GET["item_id"];
        }else {
        $msg = "<div class='alert alert-danger'>there is no item with this id!</div>";
                redirect2 ($msg , 5 , "back");
        }
        
        if (!empty($item)) {

        $stmt= $conn->prepare("update item set approve = 1 where item_id =? ");
        $stmt->execute(array($item));
        $count= $stmt->rowCount();
            if ($count > 0 ) {
                            $msg =  '<div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Well done!</h4>
                            <p>'. $count .' item approved successfully and share to your website ..</p>
                            <hr>
                            </div>' ;
                            redirect2 ($msg , 5 , "items.php") ;            }
        
        }else {
             $msg = "<div class='alert alert-danger'>there is no item with this id!</div>";
                redirect2 ($msg , 5 , "back");
            
        }
        
        
        
    }
    include $temp ."footer.php";
    
}else {
//    header ("location: index.php");
}

?>
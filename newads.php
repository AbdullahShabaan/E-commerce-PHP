<?php
session_start () ;
$pageTitle = "Add Ads";
include "init.php";

if (isset ($_SESSION["user2"])) {


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var ($_POST["name"] , FILTER_SANITIZE_STRING);
    $desc = filter_var ($_POST["desc"] , FILTER_SANITIZE_STRING);
    $price = filter_var ($_POST["price"] , FILTER_SANITIZE_NUMBER_INT);
    $country = filter_var ($_POST["country"] , FILTER_SANITIZE_STRING);
    $status = filter_var ($_POST["status"] , FILTER_SANITIZE_NUMBER_INT);
    $cat_member = filter_var ($_POST["cat_member"] , FILTER_SANITIZE_STRING);
    
    $errors = array () ;
    
    if (empty ($name)) {
        $errors [] = "<div class='alert alert-warning'>field name is empty!</div>";
    }
    
    if (empty ($desc)) {
       $errors [] = "<div class='alert alert-warning'>field description is empty!</div>";
    }
    
     if (empty ($price)) {
       $errors [] = "<div class='alert alert-warning'>price field is required </div>";
    }
    
     if (empty ($country)) {
       $errors [] = "<div class='alert alert-warning'>field country is empty!</div>";
    }
    
     if (empty ($status)) {
       $errors [] = "<div class='alert alert-warning'>Sorry! but you have to select the status of your product</div>";
    }
    
       if (empty ($cat_member)) {
       $errors [] = "<div class='alert alert-warning'>Sorry! you have to choose the category</div>";
    }
    
    
    if (!empty ($errors)) {
        foreach ($errors as $error) {
            echo $error . "<br>";
        }
    }
    
    if (empty ($errors)) {
          
                $stmt= $conn->prepare("select item_name from item where item_name =?");
                $stmt->execute(array($name));
                $row = $stmt->fetch();
                $count = $stmt->rowCount();
                if ($count > 0 ) {
                    $error = "<div class='alert alert-danger'>Item already exist!</div>" ;
                    redirect2 ($error , 5 , "back");
                    
                    
                    
                }else {
                    
                    $stmt2 = $conn->prepare("insert into item (item_name , item_description , price , made_in , status , cat_id , member_id ) values (:item_namee , :item_descriptionn , :pricee , :made_inn , :statuss , :cat_idd , :member_idd )");
                    $stmt2->execute(array("item_namee" => $name , "item_descriptionn" => $desc , "pricee" => $price , "made_inn" => $country , "statuss" => $status , "cat_idd" => $cat_member , "member_idd" => $_SESSION["id2"] ));
                    $row2 = $stmt2->fetch();
                    $counts = $stmt2->rowCount();
                    
                    if ($counts > 0 ) {
                    $mssg = "<div class='alert alert-success'><i class='fa-solid fa-check'></i> item added successfully</div>";
                    redirect2 ($mssg , 5 , "items.php?do=insert");
                    }
                }
                
                
            
 
    }
    
    
    
    
}


    
    
    
    
?>
     

          
        
        
        <h1 class="text-center" id= "member">Add New Item</h1>
				<div class="container">
					<form class="form-horizontal" action="" method="POST">
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
        
    }
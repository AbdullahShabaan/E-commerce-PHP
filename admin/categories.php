<?php
ob_start();
session_start();
$pageTitle = "Categories" ;

if (isset($_SESSION["user"])) {
    include ("init.php") ;
//checktitle ();
    
   $do = null;
    
       if (isset($_GET["do"])) {
           $do = $_GET["do"];
       }else {
           $do = "manage";
       }
    
    
    if ($do == "manage") {
        
        echo "<h1 class='text-center'>Categories</h1>";
        
        $sorting = null ;
        
        $array_sorting = ["ASC" , "DESC"];
        
        if (isset($_GET["sorting"]) && in_array($_GET["sorting"] , $array_sorting)) {
                
            $sorting = $_GET["sorting"]; 
            
        }
        
        $stmt7= $conn->prepare("SELECT * FROM categories where parent = 0  order by ordering $sorting ");
        $stmt7->execute();
        $cats = $stmt7->fetchAll();
        
        if (!empty($cats)) {
        echo "<div class='container categories'>";
        echo "<div class='card card-default'>" ;
        echo "<div class='card-header'>
        
        <strong>categories manage</strong>
        <div class = 'ordering float-right'>
        <b>Sorting</b>
        <a href='Categories.php?sorting=ASC' class='btn btn-primary m-1'>ASC</a> |
        <a href='Categories.php?sorting=DESC' class='btn btn-warning'>DESC</a> |
          <a href=categories.php?do=add  class='btn btn-primary p-1 m-1 fa fa-plus float-right btn-ms'>add new category</a>
        
        </div>
        </div>";
        echo "<div class='card-body'>";
        
        foreach ($cats as $cat) {
            echo "<div class='cat'>";
            echo "<div class='hidden-buttons'>" ;
            echo "<a href='Categories.php?do=edit&id=".$cat['id']."' class='btn btn-primary fa fa-edit'>Edit</a>" ;
            echo "<a href='Categories.php?do=delete&id=".$cat['id']."' class='btn btn-danger'>Delete</a>" ;
            echo "</div>";
            echo  "<h3> <b>"  . $cat["name"] . "</b></h3>". "<br>";
            if ($cat["description"] == null) { echo "empty description !" ; }else {echo  "<p>" .$cat["description"] ;} echo "</p>" . "<br>";
            echo "<span class='ff'> ordering number " . $cat["ordering"] . " </span>" ;
            if ($cat["visibility"] == 1 ) { echo "<span class='commenting'> <i class='fa fa-eye-slash'></i> Hidden </span>"; }else {
                echo "<span class='visibility'><i class='fa fa-eye'></i> visible </span>" ;
            } 
            if ($cat["allow_comment"] == 1 ) { echo "<span class='commenting'><i class='fa fa-close'></i> Comment off  </span>";} else { echo "<span class='visibility'><i class='fa fa-check'></i> comments turn on </span>" ; }
            if ($cat["allow_ads"] == 1 ) {echo  "<span class='commenting'><i class='fa fa-close'></i> No advertises  </span>";} else { echo "<span class='visibility' ><i class='fa fa-check'></i> ads turn on</span> " ; } 
            
            $id = $cat["id"];
            
            $child = allRecords ("*" , "categories", " where parent = $id" , " id " ,  " ASC ") ;
//            allRecords ($select , $from , $where = null , $order , $ordering = "ASC")
            if (!empty ($child)) {
            echo "<h4 class='text-success m-2'> child categories</h4>";
            echo "<ul >" ;
            foreach ($child as $c) {
            
            
                echo  "<li>" . $c["name"]. "</li>" ;
                
                        echo "<a href='Categories.php?do=edit&id=".$c['id']."' class='btn btn-primary m-1 btn-sm fa fa-edit'>Edit</a>" ;
            echo "<a href='Categories.php?do=delete&id=".$c['id']."' class='btn btn-danger   btn-sm'>Delete</a>" ;
           
            }
            echo "</ul>" ;
            }
            echo "<hr>";
            echo "</div>";
        }
        echo "</div>";
        
        
        echo "</div>";
        
        echo "</div>";
        echo "</div>";
        echo "<div class='container'>";
      
        
        }else {
                    echo "<div class='alert alert-warning'>there's no categories inserted yet</div>";
              echo "<a href=categories.php?do=add  class='btn btn-primary  fa fa-plus float-left btn-lg'> add new category</a>";

        }
    }elseif($do == "add") { ?>
        
         
        <h1 class="text-center" id= "member">add new category</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=insert" method="POST">
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">category name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="category_name" class="form-control"  autocomplete="off"  />
							</div>
						</div>
						<!-- End Username Field -->
						<!-- Start Password Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">description</label>
							<div class="col-sm-10 col-md-6">
								
								<input type="text" name="category_description"  class="form-control"  placeholder="describe your category" />
							</div>
						</div>
						<!-- End Password Field -->
						<!-- Start Email Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">ordering</label>
							<div class="col-sm-10 col-md-6">
								<input type="number" name="ordering"   class="form-control"  placeholder="ordering your category"/>
							</div>
						</div>
						<!-- End Email Field -->
                        <!--  start category parent   -->
                        
    <?php
        
       $parent = allRecords ("*" , "categories" , "where parent = 0 " , "id" ,  "ASC") ;
        
    ?>
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Parent Category</label>
							<div class="col-sm-10 col-md-6">
                                <select name="parent"> 
                                    <option value="0">none</option>    
    <?php
        foreach ($parent as $newParent) {
            echo '<option value="'.$newParent["id"].'">' . $newParent["name"] . '</option>';
        }
    ?>
                                </select>	
							</div>
						</div>
                        <!--   end category parent     -->
                        
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10 col-md-6">
                                <label for="vis-1">Yes</label>
								<input id="vis-1" type="radio" name ="Visible" value = "0" checked>
							</div>
                            <div class="col-sm-10 col-md-6">
                                <label for="vis-2">No</label>
								<input id="vis-2" type="radio" name ="Visible" value = "1">
							</div>
						</div>
                        
                        
                        
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">allow comment</label>
							<div class="col-sm-10 col-md-6">
                                <label for="vis-3">Yes</label>
								<input id="vis-3" type="radio" name ="comment" value = "0" checked>
							</div>
                            <div class="col-sm-10 col-md-6">
                                <label for="vis-4">No</label>
								<input  id="vis-4" type="radio" name ="comment" value = "1">
							</div>
						</div>
                        
                        
                        
                        
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">allow ads</label>
							<div class="col-sm-10 col-md-6">
                                <label for="vis-5">Yes</label>
								<input id="vis-5"  type="radio" name ="ads" value = "0" checked>
							</div>
                            <div class="col-sm-10 col-md-6">
                                <label for="vis-6">No</label>
								<input id="vis-6" type="radio" name ="ads" value = "1">
							</div>
						</div>
						<!-- End Full Name Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Add Category" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div><?php

        
        
        
        
    }elseif ($do == "insert") {
       
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
                $name = $_POST["category_name"] ;
                $desc = $_POST["category_description"] ;
                $order = $_POST["ordering"] ;
                $visible = $_POST["Visible"] ;
                $comment = $_POST["comment"] ;
                $ads = $_POST["ads"] ;
                $parent = $_POST["parent"];
            
                    if (empty($name) or strlen($name) > 17 or strlen($name) < 2) {
                        
                        $error = "<div class='alert alert-danger'>category name must be between 2 - 17 length and can't be empty</div>";
                        redirect2 ($error, 5 , "back");
                        
                    }else {
                        
                        $stmt= $conn->prepare("select id from categories where name =?") ;
                        $stmt->execute(array($name));
                        $row = $stmt->fetch();
                        $count = $stmt->rowCount();
                        
                        if ($count > 0) {
                            
                            $error = "<div class='alert alert-danger'>category already exist!</div>";
                            redirect2 ($error , 5 , "back");
                            
                        }else {
                            
                            $stmt6 = $conn->prepare("INSERT into categories (name , description , ordering , visibility , allow_comment	, allow_ads , parent ) VALUES (:nname , :ddesc, :oorder , :vvisible , :ccoment , :aads , :pparent)") ;
                            $stmt6->execute(array( "nname" => $name , "ddesc" => $desc , "oorder" => $order , "vvisible" => $visible , "ccoment" => $comment , "aads" => $ads , "pparent" => $parent )) ;
                            $row2 = $stmt6->fetch();
                            $count2 = $stmt6->rowCount();
                           
                            $error =  '<div class="alert alert-success" role="alert">
                            <h4 class="alert-heading">Well done!</h4>
                            <p>'. $count2 .' category inserted successfully to your website ..</p>
                            <hr>
                            </div>' ;
                            redirect2 ($error , 5 , "back") ;
                            
                            
                        }
                        
                        
                        
                    }
            
        }else {
                            $error =  '<div class="alert alert-warning" role="alert">
                            <h4 class="alert-heading">Sorry!</h4>
                            <p> you can\' browse this page directly ..</p>
                            <hr>
                            </div>' ;
                            redirect2($error , 5 , "back");
            
        }
        
        
        
    }elseif($do == "edit") {
        
        $cat1 = null ;
        
        if (isset($_GET['id']) && is_numeric($_GET['id'])) {
            $cat1 = $_GET['id'];
            
        }else {
            $cat1 = $_GET['id'];
        }
        
        $stmt = $conn->prepare("SELECT * from categories where id = ?");
        $stmt->execute(array($cat1));
        $roww = $stmt->fetch();
        $count = $stmt->rowCount();
        
        
        if ($count > 0) {?>




        <h1 class="text-center" id= "member">Edit Category</h1>
				<div class="container">
					<form class="form-horizontal" action="?do=update" method="POST">
						<!-- Start Username Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">category name</label>
							<div class="col-sm-10 col-md-6">
								<input type="text" name="category_name" class="form-control"  autocomplete="off" value ="<?php echo $roww["name"]?>" />
                                <input type="hidden" name="catid" value="<?php echo $cat1 ?>" />
							</div>
						</div>
						<!-- End Username Field -->
						<!-- Start Password Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">description</label>
							<div class="col-sm-10 col-md-6">
								
								<input type="text" name="category_description"  class="form-control"  placeholder="describe your category" 
                                       value ="<?php echo $roww["description"]?>"
                                       
                                       />
							</div>
						</div>
						<!-- End Password Field -->
<!--                        start parent  field -->
                        
                        
                                              
    <?php
        
       $parent = allRecords ("*" , "categories" , "where parent = 0 " , "id" ,  "ASC") ;
        
    ?>
                        
                        
                        <div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Parent Category</label>
							<div class="col-sm-10 col-md-6">
                                <select name="parent"> 
                                    <option value="0"  >none</option>    
    <?php
        foreach ($parent as $newParent) {
            echo '<option value="'.$newParent["id"].'" 
            
            ' ;
            if ( $roww["parent"] == $newParent["id"]){
                echo " selected";
            }
            
            echo '>' . $newParent["name"] . '</option>';
        
        }
    ?>
                                </select>	
							</div>
						</div>
                        
                        
                        
                        
<!--                        end parent field-->
                        
                        
                        
                        
						<!-- Start Email Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">ordering</label>
							<div class="col-sm-10 col-md-6">
								<input type="number" name="ordering"   class="form-control"  placeholder="ordering your category" 
                                       value="<?php echo $roww["ordering"]?>"
                                       />
							</div>
						</div>
						<!-- End Email Field -->
						<!-- Start Full Name Field -->
						<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">Visible</label>
							<div class="col-sm-10 col-md-6">
                                <label for="vis-1">Yes</label>
								<input id="vis-1" type="radio" name ="Visible" value = "0" <?php if ($roww["visibility"] == 0 ) { echo "checked" ;} ?> >
							</div>
                            <div class="col-sm-10 col-md-6">
                                <label for="vis-2">No</label>
								<input id="vis-2" type="radio" name ="Visible" value = "1"
                                       <?php if ($roww["visibility"] == 1 ) { echo "checked" ;} ?>
                                       >
							</div>
						</div>
                        
                        
                        
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">allow comment</label>
							<div class="col-sm-10 col-md-6">
                                <label for="vis-3">Yes</label>
								<input id="vis-3" type="radio" name ="comment" value = "0"  <?php if ($roww["allow_comment"] == 0 ) { echo "checked" ;} ?> >
							</div>
                            <div class="col-sm-10 col-md-6">
                                <label for="vis-4">No</label>
								<input  id="vis-4" type="radio" name ="comment" value = "1"
                                       <?php if ($roww["allow_comment"] == 1 ) { echo "checked" ;} ?>
                                       >
							</div>
						</div>
                        
                        
                        
                        
                        	<div class="form-group form-group-lg">
							<label class="col-sm-2 control-label">allow ads</label>
							<div class="col-sm-10 col-md-6">
                                <label for="vis-5">Yes</label>
								<input id="vis-5"  type="radio" name ="ads" value = "0" 
                                       
                                       
                                       <?php if ($roww["allow_ads"] == 0 ) { echo "checked" ;} ?>
                                       
                                       
                                       >
							</div>
                            <div class="col-sm-10 col-md-6">
                                <label for="vis-6">No</label>
								<input id="vis-6" type="radio" name ="ads" value = "1"
                                       
                                       <?php if ($roww["allow_ads"] == 1 ) { echo "checked" ;} ?>
                                       
                                       
                                       >
							</div>
						</div>
						<!-- End Full Name Field -->
						<!-- Start Submit Field -->
						<div class="form-group form-group-lg">
							<div class="col-sm-offset-2 col-sm-10">
								<input type="submit" value="Update Category" class="btn btn-primary btn-lg" />
							</div>
						</div>
						<!-- End Submit Field -->
					</form>
				</div>
            
            
            
        <?php }else {
            
            $error = "<div class='alert alert-warning'>there is no category with this id</div>";
            redirect2 ($error , 5 , "back");
            
        }
        
        
        
        
        
        
    }elseif($do == "update") {
        
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            $category_name = $_POST["category_name"];
            
            $description = $_POST["category_description"];
            
            $ordering =$_POST["ordering"];
            
            $visible =$_POST["Visible"];
            
            $allow_comment =$_POST["comment"];
            
            $allow_ads = $_POST["ads"];
            
            $catID = $_POST["catid"];
            
            $parent = $_POST["parent"];
            
            
            
            
            
            if (empty ($category_name)) {
                $getMessage = "<div class='alert alert-danger'>Sorry! category name field required </div>" ;
                redirect2 ($getMessage , 5 , "back");
                
                
            }else {
                $stmt10=$conn->prepare("UPDATE categories SET name =? , description =? , ordering =? , visibility =? , allow_comment =? , allow_ads =? , parent =? WHERE id =?");
                
                $stmt10->execute(array($category_name , $description , $ordering , $visible , $allow_comment , $allow_ads , $parent , $catID));
                
                $getMessage = " <div class='alert alert-success'>" . $stmt10->rowCount() . " record updated</div>";
                        redirect2 ($getMessage , 5 , "back");
            } 
            
//          
    
        }
        
        
    }elseif ($do == "delete") {
       if (isset ($_GET["id"]) && is_numeric($_GET["id"])) {
           $catidd = $_GET["id"];
           
           $stmt= $conn->prepare("select id from categories where id=?");
           $stmt->execute(array($catidd)); 
           $count= $stmt->rowCount();
            if ($count > 0) {
                
                $stmtd = $conn->prepare("delete from categories where id=?");
                $stmtd->execute(array($catidd));
                $rowCount = $stmtd->rowCount();
                
                if ($rowCount > 0) {
                    $msg = "<div class='alert alert-success'>Record deleted</div>";
                    redirect2($msg , 5 , "back");
                }
                
            } else {
                $error = "<div class='alert alert-danger'>already not exist !</div>";
                redirect2 ($error , 5 , "back");
            }
       
       
       
       }else {
           $error2 = "<div class='alert alert-warning'> there is no category with this id </div>";
           redirect2 ($error2 , 5 , "back");
       }
        
       
    }
       
    include $temp . "footer.php" ; 
}

ob_end_flush();

?>
<?php 
ob_start();
session_start() ;
$pageTitle= "Home";
if (isset($_SESSION["user"])) {
    include ("init.php") ;
    include $temp . "footer.php" ; 
    
 
    
    ?>
<div class="container home-stats ">
    <h1 class='text-center'>Dashboard</h1>
    
    <div class="row">
        <div class="col-md-3" >
            <div class="stat st-members" ><a href="members.php" ><i class="fa-solid fa-user-group"></i> total members</a>
                <span><?php echo countsgded ("user_id" , "users" , "group_id = 0"); ?></span>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat st-pending"><a href="members.php?do=manage&page=pending"><i class="fa-solid fa-user-plus"></i> pending members</a>
                <span><?php echo counts("user_id" , "users" , 0);?></span>
            </div>
        </div>   
        <div class="col-md-3">
            <div class="stat st-items"><a href="items.php"><i class="fa fa-tag"></i> total items</a>
                <span>
                <?php 
                    
               echo  countsall ("item_id" , "item" );
                    
                    
                    
                ?>
                
                
                </span>
            </div>
        </div>        
        <div class="col-md-3">
            <div class="stat st-comments"> <a href ="comments.php"><i class="fa-solid fa-comment"></i> total comments </a>
                <span><?php echo countsall("c_id" , "comments" ) ?></span>
            </div>
        </div>
    </div>

</div>

<div class="container latest">
    <div class='row'>
        <div class="col-sm-6">
            <div class ="card card-default">
                <div class="card-heading">
                    <i class="fa fa-users"></i> 
                    <?php 
                    $countUsers = 5 ; 
    
                    $countItems = 5 ;
    
                    $countComments = 5 ;
                    
                    echo "latest $countUsers members "; 
                    
                    ?>
                </div>
                <div class="card-body">
                
                    <?php
    
                             $getUsers =  getitems ("*" , "users" , "user_id" , $countUsers , "where" , "group_id = 0") ;
                            if (!empty ($getUsers)) {
                            foreach ($getUsers as $getUsers2) {
//                            echo $getUsers2["user_name"] . "<a href='members.php?do=edit&user_id=". $getUsers2['user_id'] ."' class='btn btn-primary '><i class='fa fa-edit'  float-right></i>Edit</a>" . "<br>"; 
                                
                                if ($getUsers2["reg_status"] == 0) {
                                echo '<div class="bg-light clearfix">
                               <span><a class="text-decoration-none text-dark" href ="members.php?do=edit&user_id='.$getUsers2['user_id'] .'">'.  $getUsers2["user_name"] .'</a></span>    
                                <a href="members.php?do=edit&user_id='.$getUsers2['user_id'] .' ">
                                <button type="button" class="btn btn-danger btn-sm  float-right" >Refuse</button>
                                </a>
                                
                                <a 
                                href="members.php?do=activate&user_id='.$getUsers2['user_id'] .' ">
                                <button type="button" class="btn btn-success btn-sm  float-right" >Confirm</button>
                                </a>
                                <hr>
                                </div>';
                                }else {
                                    
                              echo '<div class="bg-light clearfix">
                              
                                <span><a class="text-decoration-none text-dark" href ="members.php?do=edit&user_id='.$getUsers2['user_id'] .'">'.  $getUsers2["user_name"] .'</a></span>    
                                <a href="members.php?do=edit&user_id='.$getUsers2['user_id'] .' ">
                                <button type="button" class="btn btn-primary btn-sm  float-right" >Edit</button>
                                </a>
                                
                                <hr>
                                </div>';
                                }
                                
                                
                            }
                        }else {
                                
                                  echo "<div class='alert alert-warning'>there's no members join yet</div>";
                                 echo "<a href='members.php?do=add' class='btn btn-primary btn-sm'><i class='fa fa-plus'></i>ADD NEW MEMBER</a>" ;
                            }
                    ?>
                    
                    
                    
                </div>
        </div>
    </div>
        
    <div class="col-sm-6">
            <div class ="card card-default">
                <div class="card-heading">
                    <i class="fa fa-tag"></i> <?php echo "latest $countItems items " ; ?>
                </div>
                <div class="card-body">
                    <?php
                      $getItems =  getitems ("*" , "item" , "item_id" , $countItems) ;
    
                            if (!empty ($getItems)) {
                        foreach ($getItems as $item) {
//                            echo $item["item_name"] . "<hr>" ;
                            
                                      
                                if ($item ["approve"] == 0) {
                                echo '<div class="bg-light clearfix">
                                <span>'.  $item["item_name"] .'</span>    
                                <a href="items.php?do=delete&item_id='.$item['item_id'] .' ">
                                <button type="button" class="btn btn-danger btn-sm float-right" >Refuse</button>
                                </a>
                                
                                <a 
                                href="items.php?do=approve&item_id='.$item['item_id'] .' ">
                                <button type="button" class="btn btn-success btn-sm  float-right" >Confirm</button>
                                </a>
                                <hr>
                                </div>';
                                }else {
                                    
                              echo '<div class="bg-light clearfix">
                                <span>'.  $item["item_name"] .'</span>    
                                <a href="items.php?do=edit&item_id='.$item['item_id'] .' ">
                                <button type="button" class="btn btn-primary btn-sm  float-right" >Edit</button>
                                </a>
                                
                                <hr>
                                </div>';
                                }
                            
                        }
                        
                        }else {
                                        echo "<div class='alert alert-warning'>there's no items inserted yet</div>";
                                   echo "<a href='items.php?do=add' class='btn btn-primary btn-sm '><i class='fa fa-plus'></i>ADD NEW ITEM</a>" ;

                            }
    
                    ?>
                    
                </div>
        </div>
    </div>


        
<!--        -->
        
        
           <div class="col-sm-6">
            <div class ="card card-default">
                <div class="card-heading">
                    <i class="fa fa-comment"></i> <?php echo "latest $countComments comments " ; ?>
                </div>
                <div class="card-body">
                    <?php
    
                $stmt = $conn->prepare("SELECT comments.* ,
                item.item_name as Item_name , 
                users.user_name as user_name 
                from comments 
                inner JOIN item 
                on comments.item_id = item.item_id 
                inner JOIN users 
                on comments.user_id = users.user_id 
                order by c_id DESC
                limit 5;
                ");
                $stmt->execute();
                $row = $stmt->fetchAll();
                if (!empty ($row)) {
    
                        foreach ($row as $item) {

                            
                                      
                                if ($item ["status"] == 0) {?>
                     
                     <div class="accordion accordion-flush " >
  <div class="accordion-item">
    <h2 class="accordion-header">
      <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
        <?php echo $item["user_name"] . " commenting on item " . $item["Item_name"] ;?>
      </button>
    </h2>
    <div id="flush-collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
      <div class="accordion-body"><?php  echo  "<strong>" . $item["comment"] .  " </strong>"; 
          
          
                 echo "<a href='comments.php?do=edit&com_id=". $item['c_id'] ."' class='btn btn-primary btn-sm float-right'><i class='fa fa-edit'></i>Edit</a>";  
                            
                            echo "<a href='comments.php?do=delete&com_id=". $item['c_id'] ."' class='btn btn-danger btn-sm float-right'><i class='fa fa-close'></i>Delete</a>"  ;
          
          
          ?>
        
        
    </div>
    </div>
  </div>


</div>
                                <?php  ;
                                }
                            
                        }
                }else {
                            echo "<div class='alert alert-warning'>there's no comments </div>";

                }
                    ?>
                    
                </div>
        </div>
    </div>
</div>



<?php
                

}    else {
    
    header("location: index.php");
    
}
ob_end_flush();
    
    ?>
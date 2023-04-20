<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
<?php
session_start();
$pageTitle = "Items" ;
include "init.php";

        $itemId = null  ;

    if (isset($_GET["id"]) && is_numeric($_GET["id"] )) {
        $itemId = $_GET["id"] ;
    }
            
        $stmt = $conn->prepare("select item.* , users.user_name , categories.name 
        from item 
        inner join users
        on users.user_id = item.member_id
        inner join categories
        on item.cat_id = categories.id
        where item_id = ?");
        $stmt->execute(array($itemId));
        $count = $stmt->rowCount();

            if ($count > 0 ) {
        $row = $stmt->fetch();
                
                
                if ($row["approve"] < 1 ) {
                    echo "<div class='alert alert-danger container'>warning! this ad awaiting activation,<br> only you can see this page</div>";
                }
        ?>


<body>
  <div class="container my-5">
  <div class="container card">
    <div class="row">
    
      <div class="col-md-6">
        <h1 class="mb-3"><?php echo $row["item_name"] ?></h1>
        <h4 class="mb-3">Advertiser : <?php echo $row["user_name"] ?></h4>
        <h5 class="mb-3">Category : <?php echo "<a href='cat.php?pageid=".$row["cat_id"]."&cat_name=".$row["name"]."'>" . $row["name"] . "</a>"?></h5>
        <p class="lead">More Details : <?php echo $row["item_description"] ?></p>
        <p class="lead">Puplished on : <?php echo $row["dates"] ?></p>
        <p class="lead">Made in : <?php echo $row["made_in"] ?></p>
        <p class="lead">Rating : <?php echo $row["rating"] ?></p>
        <p class="lead">Status : <?php echo str_replace ( [1 , 2 , 3 ] , ["new" , "like new" , "old"] , $row["status"]) ?></p>
        <h2 class="mb-3">$<?php echo $row["price"] ?></h2>
          
        <form>
          <div class="form-group">
            <label for="quantity">Quantity :</label>
            <input type="number" class="form-control" id="quantity" name="quantity" min="1" max="10" value="1">
          </div>
          <button type="submit" class="btn btn-primary">buy</button>
        </form>
          
      </div>
          <div class="col-md-6">
        <img src="https://via.placeholder.com/500x300" class="img-fluid my-5" alt="صورة المنتج">
      </div>
    </div>
    
    <hr>
      
      <?php
            
          $stmt3 = $conn->prepare ("select comments.* , users.user_name 
          from comments
          inner join users
          on users.user_id = comments.user_id
          where item_id = ? 
          order by c_id DESC ; ") ;
          $stmt3->execute(array($itemId));
          $rows = $stmt3->fetchAll();
          $count = $stmt3->rowCount();
                
              
            
        ?>
   <div class="container ">

  <h4 class="my-4">Comments : </h4>
     <?php 
                
      foreach ($rows as $comm) {?>
       
  <div class="media mb-2">
    <img class="img-thumbnail mr-3 rounded-circle  " src="user.jpg" alt="صورة المستخدم">
    <div class="media-body">
      <h5 class="mt-0"><?php echo $comm["user_name"] ; ?></h5>
    <?php echo '<div class="alert alert-info col-md-6">' .$comm["comment"] . '</div>'; ?>
    <?php echo $comm["comment_date"] ; ?>
        <hr>
    </div>
  </div>
     
       
             <?php } 
            
             if (isset($_SESSION["user2"])) {
                 
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                   
                    
                $comment = filter_var ($_POST["comments"] , FILTER_SANITIZE_STRING) ;
                $user =  $_SESSION["id2"] ;
                $item = $row["item_id"];
                 
                 if (!empty ($comment)) {
                     $stmt2 = $conn->prepare("insert into comments (comment , item_id , user_id) values (:zcomment , :zitem_id , :zuser_id)");
                     $stmt2->execute(array("zcomment" => $comment , "zitem_id" => $item , "zuser_id" => $user));
                     $get = $stmt2->fetch();
                     $count = $stmt2->rowCount();
                     if ($count > 0) {
                         echo "<div class='alert alert-success'>Comment Added</div>";
                        
                     }
                     
                 }else {
                     echo "<div class='alert alert-danger'>comment can't be empty!</div>";
                 }
                    
                    
                    
                }

                 
            
             ?>
             
  <div class="card">
    <div class="card-body">
      <form action="" method="POST">
        <div class="form-group">
          <label for="comment">Add comment : </label>
          <textarea required class="form-control" name="comments" id="comment" rows="2"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
      </form>
        <?php
         
                 
        ?>
    </div>
  </div>
       <?php }else {
                 echo "<div class='alert alert-warning'><a href='login.php?do=login'>login or register </a> to add comment</div>" ;
             } 
                ?>

</div>
    </div>
  </div>
<?php

            }else {
                echo "<div class='alert alert-warning'>there's no item with this ID!</div>" ;
            }
         include "foot.php";
      ?>


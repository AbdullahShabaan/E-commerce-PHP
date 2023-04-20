<?php
session_start();
$pageTitle = "profile" ;
include "init.php";

    if (isset ($_SESSION["user2"])) {
        $name = $_SESSION["user2"];
        
        // for table users
        $stmt= $conn->prepare("SELECT * from users where user_name = ? ");
        $stmt->execute(array($name));
        $get = $stmt->fetch();
        
        $id = $get["user_id"];
        // for table items
        
        $stmt7= $conn->prepare("SELECT * FROM item where member_id = $id order by item_id DESC ");
        $stmt7->execute();
        $count = $stmt7->rowCount();
        $cats = $stmt7->fetchAll();
        
        // for comments
        
        $stmt111= $conn->prepare("SELECT comments.* , item.*  
        FROM comments
        inner join item
        on item.item_id = comments.item_id
        where user_id = $id 
        order by c_id DESC
         ");
        $stmt111->execute();
        $count111 = $stmt111->rowCount();
        $cats111 = $stmt111->fetchAll();
        
        // inner join comments & items to get items name
        

        
                $status2 = checkReg ($_SESSION["user2"]); 
              if ($status2 > 0) {
                  echo "<div class='alert alert-warning'>Your account is currently inactive and requires admin activation</div>" ;
              }
        
        
        
  
        ?>

<div class="container mt-5">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-md-3">
            <!-- صورة الملف الشخصي -->
            <img src="php.png" alt="profile photo" class="img-fluid rounded-circle">
          </div>
          <div class="col-md-9">
            <!-- معلومات الملف الشخصي -->
              
            <h5 class="card-text"><i class="fa-solid fa-user"></i> username : <?php echo $_SESSION["user2"] ; ?> </h5> <hr>
              
            <p class="card-text"><i class="fa-solid fa-file-signature"></i> full name : <?php echo $get["full_name"]?> </p>
            <p class="card-text"><i class="fa-solid fa-envelope"></i> e-mail : <?php echo $get["e_mail"]?> </p>
            <p class="card-text"><i class="fa-solid fa-calendar-days"></i> registred date : <?php echo $get["registerd_date"]?></p>
              <a href = "#" class="btn btn-primary btn-sm"> Edit your information</a>
          </div>
        </div>
      </div>
      <ul class="list-group list-group-flush">
        <li class="list-group-item container"> <h4 class="container text-center">your ads</h4>
          <?php
            if ($count > 0 ) {
          echo '<div class="row" id ="myads">' ;
            foreach ($cats as $cat ) {
                
               echo '<div class="col-md-4 my-3">
      <div class="card">' ;
                 
        echo '<img src="pexels-alexander-grey-1148521.jpg" class="card-img-top" alt="...">';
              if ($cat["approve"] < 1 ) { echo "<span class='alert alert-danger btn-sm'>ad awaiting activation.</span>" ; }
        echo '<div class="card-body">
          <h5 class="card-title ">'.$cat["item_name"] .'</h5>' ;
            
          echo '<p class="card-text">'.$cat["item_description"].'</p>
          <p class="card-text">' ; 
            
                echo '</p>
              <div >
        <span class = "float-right"> ' .$cat["dates"]. ' </span> <br>
        <span class = "float-right"> <strong>$' .$cat["price"]. '</strong> </span>
     
              <a href="items.php?id='. $cat["item_id"].'" class="btn btn-primary ">Learn More </a>' ;  
             
        echo '</div>
        </div>
      </div>
    </div>'; 
            }
            
            
            }else {
//                echo '<div class="container my-5>"' ;
              echo "<div class='alert alert-info '> you have no ads yet <a href='newads.php' class = 'btn btn-info btn-sm float-right'>create new ad</a>      </div>";
//                echo '</div>';
            }?>
              </div>
          
          
          
          </li>    
          
                <li class="list-group-item container"> 
                    <h4 class="container text-center">your comments</h4>
          <?php
             
        if ($count111 > 0) {
            foreach ($cats111 as $cat2 ) {

//          echo $cat2["comment"] . " on item " . $cat2["item_name"]. "<br>" ;
              
                echo '<div class="container my-">
        <div class="card">
          <div class="card-body">
            <div class="media mb-3">
              <img src="user.jpg" class="mr-3 rounded-circle" alt="صورة المستخدم">
              <div class="media-body">
                
                <h5 class="mt-0">you commented on <strong>'. $cat2["item_name"].'</strong> item </h5>
              
                    '."<div class='alert alert-info'>".$cat2["comment"] ."</div>". "<br>" .'
                    '.$cat2["comment_date"].'
                    
           </div>
        </div>
      </div>
    </div>
    </div>
';
                
            }
        } else {
            echo "<div class='alert alert-info'>you have no comments on onther ads</div>";
        }
            
            ?>
              
          
          
          
          </li>
      </ul>
    </div>
  </div>
        <?php
    }else {
        header("locations: login.php") ;
        exit();
    }



?>


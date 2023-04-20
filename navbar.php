
<!DOCTYPE html>
<html>
<head>
  <title>Professional Navbar Example</title>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
    
    
  <nav class="navbar navbar-expand-lg navbar-light bg-light float-right" style="height: 50px;">
      
    <a class="navbar-brand" href="#"></a>
          <?php 
          if (!isset ($_SESSION["user2"])) {?>
          <a  href="login.php?do=login">
            <span class ="float-right btn btn-danger mt-4 mr-5">Login/signup</span>
          </a> 
          
          <?php }else {
              
              
              
              ?>
 
       <div class="dropdown container">

  <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <?php echo "Edit" ; ?>
  </button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
    <a class="dropdown-item" href="profile.php">Your Profile</a>
    <a class="dropdown-item" href="profile.php#myads">Your Ads</a>
    <a class="dropdown-item" href="newads.php">add new ads</a>
    <a class="dropdown-item" href="logoutusers.php">logout</a>
  </div>
</div>
      <?php     } ?>
        
    
  </nav>
    
<!--
        if (isset ($_SESSION["user2"])) {
        echo "Hello " . $_SESSION["user2"] ;
        }else {
            echo "Hello" ;
        } 
-->
    
    
  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand  ml-5" href="index.php"><h2>E-Mart.</h2>
      </a>
      <?php
         if (isset ($_SESSION["user2"])) {
        echo "Hello " . $_SESSION["user2"] ;
        }
      ?>
      
        
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
      <ul class="navbar-nav">
<?php
//     $get = getCat();
     $get = allRecords ("*" , "categories" , "where parent = 0 " , "id" ,  "ASC");
foreach ($get as $gets){
    echo "<li class='nav-item'><a class= 'nav-link' href='cat.php?pageid=".$gets["id"]."&cat_name=".str_replace ( " " , "-" , ucfirst ($gets["name"]))."'> " . $gets ["name"] . " </a></li>" ;
}
   ?>
      </ul>
    </div>
  </nav>
</body>
</html>
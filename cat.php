

<?php 
$pageTitle = "Categories";
session_start();
include "init.php"; 

ini_set('display_errors' , 'on');
error_reporting (E_ALL);
?>

<div class="container">
    
    <?php
    $catreplace =  str_replace ( "-" ,  " "  , $_GET["cat_name"] ) ;
    $get = getCats2 ($catreplace) ;
        echo '<div class="jumbotron text-center">
        <h1>'. str_replace ( "-" ,  " "  , ucfirst( $_GET["cat_name"]) ).'</h1>
    <p>' ;
            foreach ($get as $gets ){
                echo $gets["description"] ;
            } 
        
        echo '</p>
   
    </div>' ;
    $get_item = getItemss ($_GET["pageid"]) ;
        
    if (!empty($get_item)) {
    
echo '<div class="container">' ;
  echo '<div class="row">' ;
    foreach ($get_item as $item) {
        
    echo '<div class="col-md-4 my-3">
      <div class="card">
        <img src="pexels-alexander-grey-1148521.jpg" class="card-img-top" alt="...">
        <div class="card-body">
          <h5 class="card-title">'.$item["item_name"] .'</h5>
          <p class="card-text">'.$item["item_description"].'</p>
          <p class="card-text">'.$item["dates"].'</p>
              <a href="items.php?id='. $item["item_id"].'" class="btn btn-primary">Learn More</a> 
              <div class="float-right">
        <span > <strong>' .$item["price"]. '</strong> </span>
        <i class="fa-solid fa-dollar-sign"></i>
        </div>
        </div>
      </div>
    </div>';
//        echo $item["item_name"] . "<br>";
  
        
    }
        echo "</div>";
       
        echo "</div>";
    }
echo "</div>" ;
include  "foot.php";
    ?>
    






























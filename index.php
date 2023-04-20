
<?php 
session_start();
$pageTitle = "E-Mart";
include "init.php";
?>
<!--
<div class="container-fluid bg-transparent p-0 m-0" style="background-image: url('pexels-negative-space-34577.jpg'); background-size: cover; background-repeat: no-repeat; height: 90vh;">
   محتويات العنصر هنا 
    <div class="bg-transparent p-5 bg-black">
    <h1 class="text-white text-center ">"Welcome to our E-Mart<br>, where we connect buyers and sellers to make your shopping experience easy and convenient."</h1>
    </div>
</div>
-->

<div class="bg-image " style="background-image: url('pexels-negative-space-34577.jpg'); background-size: cover; background-repeat: no-repeat; height: 90vh; ">
  <div class="bg-overlay"></div>
  <div class="container p-5 ">
    <h1 class="bg-primary text-white text-center"></h1>
    <p class="lead text-white text-center"></p>
  </div>


  <section id="hero" class="d-flex align-items-center">

    <div class="container-fluid" data-aos="zoom-out" data-aos-delay="100">
      <div class="row justify-content-center">
        <div class="col-xl-10">
          <div class="row">
             
            <div class="col-xl-5 bg-black" style="opacity: 0.9;">
              <h1 class="text-white"><b>"Welcome to our <br> E-Mart,</b></h1>
                <h2 class="text-white" ><b>where we connect buyers and sellers to make your shopping experience easy and convenient."</b></h2>
              <a href="login.php?do=login" class="btn btn-danger mt-4 btn-lg">Get Started</a>
            </div>
          </div>
        </div>
      </div>
    </div>

  </section>
</div>
<hr>
<?php
 
//$stmt = $conn->prepare ("select * from item where approve = 1 order by item_id DESC") ;
//$stmt->execute();
//$get_item = $stmt->fetchAll() ;

$get_item = allRecords ("*" , "item" , " where approve = 1 " , "item_id" , " DESC ") ;



echo '<div class="container">' ;
  echo '<div class="row">' ;
    foreach ($get_item as $item) {
        
    echo '<div class="col-md-4 my-4">
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
include  "foot.php";
    ?>


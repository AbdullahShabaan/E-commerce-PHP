<?php
// frontend
function getCat () {
    global $conn ;
    $stmt7= $conn->prepare("SELECT * FROM categories order by id ASC");
    $stmt7->execute();
    $cats = $stmt7->fetchAll();
    return $cats ;
}

function getCats2 ($value) {
    global $conn ;
    $stmt7= $conn->prepare("SELECT * FROM categories where name = ?  order by id ASC");
    $stmt7->execute(array($value));
    $cats = $stmt7->fetchAll();
    return $cats ;
}


function getItemss ($id) {
    
    global $conn ;
    $stmt7= $conn->prepare("SELECT * FROM item where cat_id = $id And approve = 1 order by item_id DESC ");
    $stmt7->execute();
    $count = $stmt7->rowCount();
    $cats = $stmt7->fetchAll();
    if ($count > 0 ){
    return $cats ;
}else {
      
        
       echo  '<div class= "alert alert-warning" style="text-align:center; padding:50px;">
             <h2>Oops! This section is currently empty.</h2>
             <p>We are sorry to inform you that this section is currently empty. We are working hard to add more content soon.</p>
             </div>' ;
    }
}





function checkReg ($user) {
    global $conn ;
    $stmt= $conn->prepare("SELECT user_name , reg_status from users where user_name = ? AND reg_status = 0 ");
    $stmt->execute(array($user)) ;
    $status = $stmt->rowCount();
    return $status ;
    
}

// backend

function checktitle () {
    
    global $pageTitle ;
    
if (isset($pageTitle)) {
    
    echo $pageTitle ;
    
  } else {
    
    echo "default";
    
} 
    
}
    

// redirect function for message and header to onther page V1
function redirect ($error , $seconds = 7) {
        echo "<div class=alert alert-danger>" . $error . "</div>" ;
        echo "<div class='alert alert-info'> you will be redirected after $seconds Seconds. </div>" ;
        
        
    header("refresh:$seconds; url=dashboard.php");
    exit();
    
}
// redirect function for message and header to onther page V2
function redirect2 ($getMessage , $seconds =3 , $url = null) {
    
    if ($url === null) {
        $url = "dashboard.php" ;
        
    }else {
        if (isset ($_SERVER["HTTP_REFERER"]) && !empty ($_SERVER["HTTP_REFERER"])) {
        $url = $_SERVER["HTTP_REFERER"];
        }else {
            $url = "dashboard.php";
        } 
        
    }
    
    echo $getMessage;
    echo "<div class='alert alert-info'>you will be redirected to $url after $seconds seconds</div>";
    header("refresh:$seconds;url=$url");
    exit();
    
    
}





function check_user ($select , $from , $value ) {
    
    global $conn; 
    
    $stmt= $conn->prepare("SELECT $select from $from where $select = ? ");
    $stmt->execute(array($value));
    $row= $stmt->fetch();
    $count = $stmt->rowCount();
    return $count ;
    
  

}



// count members v1

function counts ($item , $from , $status) {
    global $conn ;
    $stmt2=$conn->prepare("SELECT count($item) FROM $from where reg_status = $status");
    $stmt2->execute();
    return $stmt2->fetchColumn();
    
}

// count v2
function countsall ($item , $from ) {
    global $conn ;
    $stmt2=$conn->prepare("SELECT count($item) FROM $from ");
    $stmt2->execute();
    return $stmt2->fetchColumn();
    
}

function countsgded ($item , $from , $status = 0) {
    global $conn ;
    $stmt2=$conn->prepare("SELECT count($item) FROM $from where $item = $status");
    $stmt2->execute();
    return $stmt2->fetchColumn();
    
}


// get leates items from database 

function getitems ($select , $table , $orderby , $limit , $where = null , $item = null ) {
    global $conn ;
    
    $stmt4 = $conn->prepare("SELECT $select FROM $table $where $item ORDER BY $orderby DESC LIMIT $limit ");
    $stmt4->execute();
    $gets = $stmt4->fetchAll();
    return $gets ;
    
    
}


// get all records (Big function)

function allRecords ($select , $from , $where = null , $order , $ordering = "ASC") {
    global $conn ;
    $stmt = $conn->prepare("SELECT $select FROM $from $where order by $order $ordering ");
    $stmt->execute();
    $row = $stmt->fetchAll();
//    $count = $stmt->rowCount();
    return $row ;
    
    
}











?>
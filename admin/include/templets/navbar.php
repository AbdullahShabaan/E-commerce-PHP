<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container" >
        <a class="navbar-brand" href="dashboard.php"><?php echo "<i class='fa-solid fa-house'></i>  ". $_SESSION["user"] . "."?></a>
   
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#app-nav" aria-controls="app-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="app-nav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="Categories.php"><?php echo lang ("Categories")?></a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="items.php"><?php echo lang ("items")?></a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="comments.php"><?php echo lang ("comments")?></a>
                </li>
                
                <li class="nav-item">
                    <a  href= "members.php" class="nav-link active" aria-current="page" href="#"><?php echo lang ("manage")?></a>
                </li>
            </ul>
     
            <ul class="nav navbar-nav navbar-right">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle active" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo lang ("m")?>
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="members.php?do=edit&user_id=<?php echo $_SESSION["id"]?>"><?php echo lang ("Edit") ?></a></li>
                        <li><a class="dropdown-item" href="#"><?php echo lang ("settings") ?></a></li>
                        <li><a class="dropdown-item" href="..\index.php"><?php echo lang ("view") ?></a></li>
                        <li><a class="dropdown-item" href="logout.php"><?php echo lang ("logout") ?></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
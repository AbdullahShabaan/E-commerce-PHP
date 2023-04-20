<?php

function lang ($phrase) {
    static $lang = array (
        // home page
    "admin" =>  "Admin Home",
    "Categories" => "Categories",
    "items" => "Items",
    "comments" => "Comments",
    "manage" => "Members",
        
        
        
        // menu
    "m" =>  "Menu",
    "Edit" =>  "Edit profile",
    "settings" =>  "Settings",
    "view" =>  "Explore as guest",
    "logout" =>  "Logout",
        
    
    );
return $lang [$phrase];
}


?>
<?php
session_start ();

if (isset ($_SESSION["user2"])) {
    session_unset();
    header ("location: index.php");
    exit();
}

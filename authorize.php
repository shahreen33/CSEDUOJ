<?php
require 'database.php';

session_start();

if(isset($_SESSION["id"])){
    header("Location: homepage.php");
exit(); 

}
?>
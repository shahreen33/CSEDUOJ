<html>
    <head>
        <link rel="icon" type="image/gif" href="logo.png" />
<meta charset="utf-8">

<link rel="stylesheet" href="register.css" >

<title>Log In</title>
<style>
    body{
        background-image: url("register_msg.jpg");
    }
</style>
</head>

<body>
   <img src="other.png" style="width: 100%">

<?php
global $con;
require 'database.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
    $email = $_GET['email'];
    $id = $_GET['hash'];
    $qry = "UPDATE users SET verified='1' WHERE id='$id'";
    $res = mysqli_query($con, $qry);
    if($res){
     echo "<div class='form'>
                        <h2>Your account is now verified. You can now <a href=index.php>Log In</a></h2>
                         </div>";
    }
 else {
      echo "<div class='form'>
                        <h2A problem occured. Please try again.</h2>
                         </div>";
}
?>
</body>
</html>
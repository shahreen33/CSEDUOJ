<!DOCTYPE html>
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
  
<?php

require('database.php');
session_start();
global $con;
if (isset($_REQUEST['id'])){
        $id = stripslashes($_REQUEST['id']);
	$id = mysqli_real_escape_string($con,$id);
  
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($con,$password);
        $password = sha1($password);
        $responses = "show_responses.php";
        $query = "SELECT * FROM users WHERE id = '$id' AND password = '$password'";
        $result = mysqli_query($con,$query);
        $count = mysqli_num_rows($result);
        if($count == 1){
                $_SESSION['id'] = $id;
                
                header("Location: authorize.php");
                echo "<div class='form'>
                <h2>Log in successful.</h2>
                </div>";
        
     }
      else
      {
                echo "<div class='form'>
                        <h2>Ooops! There has been a problem!</h2>
                        <br/>Error entering User id or password</div>";
   
                echo "<br/>Click here to <a href='register.php'>Register</a> or <a href='login.php'>Log In</a> </div>";
       }
}
   
   ?>
</body>
</html>
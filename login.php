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
 <img src="other.png" style="width: 100%">
<?php
error_reporting(E_ERROR | E_PARSE);
require('database.php');
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
                $row = mysqli_fetch_array($result);
                $verified = $row['verified'];
                if($verified == '0')
                {
                     echo "<div class='form'>
                        <h2>Your account is not verified yet. Please check your email to get the link to activate your account!</h2>
                         </div>";
                }
                else
                {
                    session_start();
                    $_SESSION['id'] = $id;
                    header("Location: authorize.php");
                
                }
     }
      else
      {
                echo "<div class='form'>
                        <h3>Ooops! There has been a problem!</h3>
                        <br/>Error entering User id or password</div>";
   
                echo "<br/>Click here to <a href='index.php'>Register</a> or <a href='index.php'>Log In</a> </div>";
       }
}
   
   ?>
 <footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
 <p class="w3-medium">Powered by <a href="https://csedu.du.ac.bd" target="_blank">CSEDU</a></p>
</footer>
</body>
</html>
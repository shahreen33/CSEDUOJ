<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/gif" href="logo.png" />
<meta charset="utf-8">
<link rel="stylesheet" href="register.css">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="latin.css">
<link rel="stylesheet" href="font-awesome.css">
<title>Register</title>
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
include 'SendEmail.php';
global $con;
if (isset($_REQUEST['name'])){
	$name = stripslashes($_REQUEST['name']);
	$name = mysqli_real_escape_string($con,$name); 
        $id = stripslashes($_REQUEST['id']);
	$id = mysqli_real_escape_string($con,$id); 
	$email = stripslashes($_REQUEST['email']);
	$email = mysqli_real_escape_string($con,$email);
  
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($con,$password);
        $password = sha1($password);
        
        $responses = "show_responses.php";
        $query = "INSERT into users (name,id, email, password, verified) VALUES ('$name','$id', '$email', '$password','0')";
        $result = mysqli_query($con,$query);
        if($result){
       
                echo "<div class='form'>
                <h2>Registration Successful</h2>
                <h2>An email has been sent to your profile. Please click the link in the email to verify your account.<h2>
                <br/>Click here to <a href='index.php'>Log In</a></div>";
                
                $emailSender = new SendEmail();
                $emailSender->sendVerificationBySwift($email, $name, $id);
                
        
     }
      else
      {
                echo "<div class='form'>
                        <h2>There has been a problem!</h2>
                        <br/>ID is already in use. </div>";
   
                echo "<br/>Click here to <a href='index.php'>register again</a></div>";
       }
}

?>
   
 

</body>
</html>

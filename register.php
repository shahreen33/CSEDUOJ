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
  
<?php
require('database.php');
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
        $query = "INSERT into users (name,id, email, password) VALUES ('$name','$id', '$email', '$password')";
        $result = mysqli_query($con,$query);
        if($result){
       
                echo "<div class='form'>
                <h2>Registration Successful</h2>
                <br/>Or Click here to <a href='index.php'>Log In</a></div>";
        
     }
      else
      {
                echo "<div class='form'>
                        <h2>There has been a problem!</h2>
                        <br/>ID is already in use. </div>";
   
                echo "<br/>Click here to <a href='index.php'>submit again</a></div>";
       }
}

?>
   
 

</body>
</html>

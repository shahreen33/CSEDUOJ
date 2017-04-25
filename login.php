<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<link rel="stylesheet" href="register.css" >

<title>Log In</title>
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
   
    else{
            ?>
            <div class="form">
            <h2>Log In</h2>
            <form name="userverification" action="" method="post">
            <br> <input type="text" name="id" placeholder="ID" required /><br>
            <br><input type="password" name="password" placeholder="Password" required /><br>
            <br><input type="submit" name="submit" value="Submit" /> 
            </form>
            </div>
            <!--<a href="signup.php" class="button">SIGN UP</a>-->
            <?php 
            echo "<br/>Click here to <a href='signin.php'>Sign In</a></div>";
    } ?>
</body>
</html>
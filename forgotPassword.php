<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" type="image/gif" href="logo.png" />
<meta charset="utf-8">

<link rel="stylesheet" href="register.css" >

<title>Reset password</title>
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
require 'database.php';
include 'SendEmail.php';
global $con; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    if(isset($_REQUEST['email']))
    {
        $email = $_REQUEST['email'];
        $email = mysqli_real_escape_string($con,$email);
        
        $qry = "SELECT * from users where email='$email'";
        $res = mysqli_query($con, $qry);
    
        $count = mysqli_num_rows($res);
        if($count==1)
        {
            $row = mysqli_fetch_array($res);
            $name = $row['name'];
            $email= $row['email'];
            $id = $row['id'];
            
            $emailSender = new SendEmail();
            $emailSender->sendPasswordBySwift($email, $name, $id);
              echo "<div class='form'>
              <h2>An email has been sent with the reset password link.</h2>
              <br/>Click here to <a href='index.php'>Log In</a></div>";
        }
        else
        {
            echo "<div class='form'>
          <h2>Email account not recognized.</h2>
          <br/>Click here to <a href='index.php'>Log In</a></div>";
        }
     
    }
     else
     {
         ?>
     
        <div class="form">
            <h2>Please enter your email</h2>
            <form name="passwordReset" action="" method="post">
            <br> <input type="email" name="email" required /><br>
            <br><input type="submit" name="submit" value="Submit" /> 
            </form>
            </div>
            <?php
     }
     ?>
     
</body>
</html>
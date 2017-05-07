<!DOCTYPE html>
<html>
    <head>
        <link rel="icon" type="image/gif" href="logo.png" />
<meta charset="utf-8">

<link rel="stylesheet" href="register.css" >

<title>Change Password</title>
<style>
    body{
        background-image: url("register_msg.jpg");
    }
</style>
</head>

<body>
    <img src="other.png" style="width: 100%">
<?php
require 'database.php';
global $con; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
session_start();

    if(isset($_REQUEST['currentPass']))
    {
        $id = $_GET['id'];
        $qry = "SELECT * from users where id='$id'";
        $res = mysqli_query($con, $qry);
        $row = mysqli_fetch_array($res);
        $name = $row['name'];
         $email= $row['email'];
        $password = $row['password'];
        $currrentPass = $_REQUEST['currentPass'];
        $currentPass = mysqli_real_escape_string($con,$currrentPass);
        $currentPass = sha1($currentPass);
        $newPass = $_REQUEST['newPass'];
        $newPass = mysqli_real_escape_string($con,$newPass);
        $newPass = sha1($newPass);
         if($password == $currentPass)
         {
              $qry = "UPDATE users SET password = '$newPass' WHERE id='$id'";
              $res = mysqli_query($con, $qry);
              if($res)
              {
                    session_destroy();
                    echo "<div class='form w3-center'>
                <h3>Password Changed</h3>
                <br>Click here to <a href='index.php'>Log In</a></div>";
              }
         }
         else
         {
           echo "<div class='form'>
                <h2>You entered a wrong current password.</h2>
                <br/>Click here to <a href='changePassword.php?id=".$id."'>try again.</a></div>";   
         }
     
    }
     else
     {
         ?>
     
    <div class="form">
            
            <h2>Change Password</h2>
            <form name="passwordChange" action="" method="post">
            <br> <input type="password" name="currentPass" placeholder="Current Password" required /><br>
            <br><input type="password" name="newPass" placeholder="New Password" required /><br>
            <br><input type="submit" name="submit" value="Submit" /> 
            </form>
            </div>
            <!--<a href="signup.php" class="button">SIGN UP</a>-->
           
            <br/>Click here to <a href='index.php'>register</a>;
            <?php
     }
     ?>
     
</body>
</html>
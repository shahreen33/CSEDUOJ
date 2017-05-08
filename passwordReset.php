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
error_reporting(E_ERROR | E_PARSE);
require 'database.php';
global $con; 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

    if(isset($_REQUEST['newPass']))
    {
        $id = $_GET['hash'];
        $qry = "SELECT * from users where id='$id'";
        $res = mysqli_query($con, $qry);
        $row = mysqli_fetch_array($res);
        $name = $row['name'];
         $email= $row['email'];
        $password = $row['password'];
        $newPass = $_REQUEST['newPass'];
        $newPass = mysqli_real_escape_string($con,$newPass);
        $newPass = sha1($newPass);
          $qry = "UPDATE users SET password = '$newPass' WHERE id='$id'";
              $res = mysqli_query($con, $qry);
              if($res)
              {
                    echo "<div class='form'>
                <h3>Password Changed</h3>
                <br/>Click here to <a href='index.php'>Log In</a></div>";
              }
     
    }
     else
     {
         ?>
     
        <div class="form">
            <h2>Change Password</h2>
            <form name="passwordReset" action="" method="post">
                <br> <input type="password" name="newPass" placeholder="New Password" required /><br>
            <br><input type="submit" name="submit" value="Submit" /> 
            </form>
            </div>
            <!--<a href="signup.php" class="button">SIGN UP</a>-->
           
            <?php
     }
     ?>
     <footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
 <p class="w3-medium">Powered by <a href="https://csedu.du.ac.bd" target="_blank">CSEDU</a></p>
</footer>
</body>
</html>
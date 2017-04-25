<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<link rel="stylesheet" href="register.css">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="latin.css">
<link rel="stylesheet" href="font-awesome.css">
<title>Sign Up</title>
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
                <br/>Or Click here to <a href='login.php'>Log In</a></div>";
        
     }
      else
      {
                echo "<div class='form'>
                        <h2>There has been a problem!</h2>
                        <br/>ID is already in use. </div>";
   
                echo "<br/>Click here to <a href='index.php'>submit again</a></div>";
       }
}
   
    else{
            ?>
            <div class="form">
            <h2>User Information Form</h2>
            <form name="registration" action="" method="post">
            <br> <input type="text" name="name" placeholder="Name" required /><br>
            <br> <input type="text" name="id" placeholder="ID" required /><br>
            <br><input type="email" name="email" placeholder="Email" required /><br>
            <br><input id ="password" type="password" onkeyup="passwordValidator()"  name="password" placeholder="Password" required />
            <p id="warning_msg"></p><br>
            <br><input type="submit" name="submit" value="Submit" /> 
            </form>
            </div>
    <script>
        function passwordValidator()
        {
            var p = document.getElementById("password").value;
            var pass = p.toString();
            var len = pass.length;
            var digitOk = 0, capitalOk = 0, needResponse= 0;
            
            for(var i = 0; i<len; i++)
            {
                
                if(pass.charAt(i)>='0' && pass.charAt(i) <='9')
                {
                    digitOk = 1;
                    break;
                }
            }
            for(var i = 0; i<len; i++)
            {
                if(pass.charAt(i)>='A' && pass.charAt(i) <='Z')
                {
                    capitalOk = 1;
                    break;
                }
            }
            var response = "password must contain atleast ";
            console.log(pass+" "+ digitOk+" "+capitalOk);
            
            if((digitOk==0 || capitalOk == 0) && len <8)
            {
               
                needResponse = 1;
                response+="a digit, a block letter and 8 characters.";
            }
            else if((digitOk==0 || capitalOk == 0) && len >=8)
            {
                needResponse = 1;
                response+="a digit and a block letter.";
            }
            
            else if(len  < 8)
            {
                needResponse = 1;
                response+="8 characters.";
            }
            else
            {
                needResponse = 0;
            }
            if(needResponse == 0)
                response = "";
            document.getElementById("warning_msg").innerHTML = response;
                
        }
</script>
            <!--<a href="signup.php" class="button">SIGN UP</a>-->
            <?php 
            echo "<br/>Click here to <a href='login.php'>Log In</a></div>";
    } ?>
</body>
</html>

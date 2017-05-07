<html>
<head>
<link rel="icon" type="image/gif" href="logo.png" />
<meta charset="utf-8">
<link rel="stylesheet" href="addProblem.css">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="latin.css">
<link rel="stylesheet" href="font-awesome.css">
<title>Problem Page</title>
</head>
<body>
    <style>
        body{
            background-image: url("register_msg.jpg");
        }
        </style>
       <img src="other.png" style="width: 100%">
<?php
error_reporting(E_ERROR | E_PARSE);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require 'database.php';
 include 'getSerial.php';
 include 'submitter.php';
 date_default_timezone_set('Asia/Bangkok');
 
if(isset($_REQUEST['code']))
{
    $contestId = $_REQUEST['contestId'];
    $problemIdMod = $_REQUEST['problemIdMod'];
     $code = $_REQUEST['code'];
    $lang = $_REQUEST['lang']; 
    
    for ($x = 0;  ; $x++) {
             $submissionId = rand(1,100000);
             $query = "SELECT * from contest_submission WHERE submissionId='$submissionId'";
              $result = mysqli_query($con, $query);
              $count = mysqli_num_rows($result);
                if($count == 0)
                    break;
        } 
    
    $address = "Submissions/".$submissionId.".txt";
    $myfile = fopen($address, "w");
    chmod($address, 0777);
    fwrite($myfile, $code);
    $problemId = substr($problemIdMod, 4,strlen($problemIdMod)-4);
   
    $verdict = submit('spoj', $problemId, $address, $lang);
    
    $time = time()-3600;
    $submissionTime = date("Y-m-d h:i:s", $time);
      
       session_start();
       $userId = $_SESSION['id']; 
       $query = "SELECT * from contest_problem WHERE contestId='$contestId' AND problemIdMod='$problemIdMod'";
       $res = mysqli_query($con, $query);
       $row = mysqli_fetch_array($res);
        $A = new getSerial();
        
       
        $serial = $A->serialNo($row['serial']);
         $query = "INSERT into contest_submission (userId, contestId, problemIdMod,submissionId, serial, verdict ,submissionTime) VALUES ('$userId','$contestId','$problemIdMod','$submissionId', '$serial','$verdict','$submissionTime')";
    
             $result = mysqli_query($con, $query);
             if($result)
             {
                echo "<div class='form'>
                <h2>Submission complete!</h2>
                <h2>Verdict: ".$verdict."</h2>";
             }
}
?>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/gif" href="logo.png" />
<meta charset="utf-8">
<link rel="stylesheet" href="addProblem.css">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="latin.css">
<link rel="stylesheet" href="font-awesome.css">
<title>Create Contest</title>
</head>
<body>
    <style>
        body{
            background-image: url("register_msg.jpg");
        }
    input[type=date] {
    width: 20%;
    margin: 5px 5px;
    border-radius: 4px;
    border: 2px solid #ccc;
    font-size: 16px;
    background-color: white;
    background-position: 360px 2px;
    background-repeat: no-repeat;
    padding: 10px 15px 10px 15px;
}   
 input[type=time] {
    width: 20%;
    margin: 5px 5px;
    border-radius: 4px;
    border: 2px solid #ccc;
    font-size: 16px;
    background-color: white;
    background-position: 360px 2px;
    background-repeat: no-repeat;
    padding: 10px 15px 10px 15px;
}   
   input[type=number] {
    width: 10%;
    margin: 5px 5px;
    border-radius: 4px;
    border: 2px solid #ccc;
    font-size: 16px;
    background-color: white;
    background-position: 360px 2px;
    background-repeat: no-repeat;
    padding: 10px 15px 10px 15px;
}  
select{
     width: 20%;
    margin: 5px 5px;
    border-radius: 4px;
    border: 2px solid #ccc;
    font-size: 16px;
    background-color: white;
    background-position: 360px 2px;
    background-repeat: no-repeat;
    padding: 10px 15px 10px 15px;
}  
.button {
    background-color: #4CAF50;
    border: none;
    color: white;
    padding: 10px 15px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 5px 8px;
    cursor: pointer;
}
    </style>
          <img src="other.png" style="width: 100%">
<?php
error_reporting(E_ERROR | E_PARSE);
require('database.php');
session_start();
global $con;
if (isset($_REQUEST['contestTitle'])){
	$contestTitle = stripslashes($_REQUEST['contestTitle']);
	$contestTitle = mysqli_real_escape_string($con,$contestTitle); 
        $contestStartDate = stripslashes($_REQUEST['contestDate']);
	$contestEndDate = mysqli_real_escape_string($con,$contestStartDate);
        $contestStartTime = stripslashes($_REQUEST['contestTime']);
        $contestStartTime = mysqli_real_escape_string($con, $contestStartTime);
	$contestDurationHours = stripslashes($_REQUEST['contestDurationHours']);
	$contestDurationHours = mysqli_real_escape_string($con,$contestDurationHours);
        
        $contestDurationMinutes = stripslashes($_REQUEST['contestDurationMinutes']);
	$contestDurationMinutes = mysqli_real_escape_string($con,$contestDurationMinutes);
  
	$contestDescription = stripslashes($_REQUEST['contestDescription']);
	$contestDescription = mysqli_real_escape_string($con,$contestDescription);
      
        $contestAnnouncements = stripslashes($_REQUEST['contestAnnouncements']);
	$contestAnnouncements = mysqli_real_escape_string($con,$contestAnnouncements);
        
        $contestDuration = $contestDurationHours * 60 + $contestDurationMinutes;
        list($contestHour,$contestMinutes) = explode(':',$contestStartTime);
        $days = (int)($contestDuration / (24*60));
        
        $hours = (int)($contestDuration/60);
        $hours = $hours - $days*24;
        $minutes =  $contestDuration - $days*24*60;
        $minutes = $minutes%60;
        $date = date_create($contestStartDate);
        $interval = "P".$days."D";
        date_add($date,new DateInterval($interval));
        
        $finalhour = $contestHour+$hours;
        if($finalhour>23)
             date_add($date,new DateInterval('P1D'));
        $finalhour = $finalhour%24;
        
     
        
        $finalmin = $contestMinutes+$minutes;
        $finalmin = $finalmin%60;
        if($finalmin<10)
            $finalmin="0".$finalmin;
        if($finalhour<10)
            $finalhour="0".$finalhour;
        $temp = $finalhour.":".$finalmin.":00";
        
        
        $tempo = date_format($date, 'Y-m-d');
        $contestEndDate="";
        $contestEndDate= $contestEndDate.$tempo;
        
        
        
        $contestEndTime = $temp;
        $contestStartTime = $contestStartTime.":00";
        $contestStatus = 0;
      
        
        
        $responses = "show_responses.php";
       
        for ($x = 0;  ; $x++) {
             $contestId = rand(1,100000);
             $query = "SELECT * from contests WHERE contestId='$contestId'";
              $result = mysqli_query($con, $query);
              $count = mysqli_num_rows($result);
                if($count == 0)
                    break;
        } 
        $setterId = $_SESSION['id'];
        $query = "INSERT into contests (contestTitle,contestId, contestStartDate,contestStartTime,contestDuration, contestEndDate, contestEndTime, contestDescription, contestAnnouncements,contestStatus, setterId) VALUES ('$contestTitle','$contestId','$contestStartDate','$contestStartTime', '$contestDuration','$contestEndDate','$contestEndTime', '$contestDescription', '$contestAnnouncements','$contestStatus', '$setterId')";
        $result = mysqli_query($con,$query);
        
        if($result)
        {
                $serial = 1;
                foreach ($_POST['oj'] as $key => $value) 
                {
                    $oj = $_POST["oj"][$key];
                    $probId = $_POST["probId"][$key];
                    $probName = $_POST["probName"][$key];
                    $probIdMod = $oj.$probId;
                    $query = "SELECT * from problemlist WHERE problemIdMod='$probIdMod'";
                    $result = mysqli_query($con, $query);
                    $rows = mysqli_num_rows($result);
                    if($rows == 0)
                    {
                        $query = "insert into problemlist(problemId,oj, problemName, problemIdMod) values ('$probId','$oj', '$probName', '$probIdMod')";
                        $result = mysqli_query($con, $query);     
                    }
                    echo $contestId;
                    $solvecount = 0;
                    $query = "insert into contest_problem(contestId, problemIdMod,serial, solvecount) values ('$contestId', '$probIdMod','$serial', '$solvecount')";
                    $result = mysqli_query($con, $query); 
                    $serial = $serial+1;
                    
                    
                }

                echo "<div class='form'>
                        <h2>Your contest has been created successfully</h2></div>";
                $contestUrl = 'showContest.php?id='.$contestId;
                echo "<br/>Click here to <a href='".$contestUrl."'>go to your contest page.</a></div>";
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
            <h2 style="color:black;">Create Contest</h2>
            <h3>1. Basic Information</h3>
            <form name="createContest" action="" method="post">
            <br> <input type="text" name="contestTitle" placeholder="Contest Title" required  />Keep as short as possible<br>
            <br><input type="date" name="contestDate" required/> Starting date<br>
            <br><input type="time" name="contestTime" required/> Starting time<br>
            <br><input type="number" name="contestDurationHours" min="1" max="240" placeholder="Hours"/><input type="number" name="contestDurationMinutes" min="0" max="59" placeholder="Minutes"/>Duration<br>
            <br><input type="text" name="contestDescription" placeholder="Description"/>Write any description if needed.<br>
            <br><input type="text" name="contestAnnouncements" placeholder="Announcements"/>Write any announcement if needed.<br>
            <p id="warning_msg"></p><br>
            <h3>2. Add problems</h3>
            <input type="button" value="Add problem" onClick="addRow()"/>
            <input type="button" value="Delete Problem" onClick="deleteRow()"/>
            <p id ="msg" />
            <script>
              function addRow()
              {
                   
                  var table = document.getElementById("problemList");
                  var len = table.rows.length;
                   console.log(len);
                 
                      
                  if(len==26)
                  {
                     
                      var msg = document.getElementById("msg");
                      msg.innerHTML = "*You cannot add more than 26 problems";
                  }
                  else
                  {
                     var msg = document.getElementById("msg");
                     msg.innerHTML = "";
                     var row = table.insertRow(len);
                   
                    var oj = row.insertCell(0);
                    var probId = row.insertCell(1);
                    var probName = row.insertCell(2);
                    var probTitle = row.insertCell(3);
                    oj.innerHTML = '<select id="oj" name="oj[]" style="width:120px;"><option value="SPOJ">SPOJ</option><option value="codeforces">Codeforces</option></select>';
                    probId.innerHTML = ' <input id="probId" type="text" style="width:120px;" placeholder="Problem Id" name="probId[]" onkeyup="crawler('+len+')" >';
                    probName.innerHTML = '<input type="text" style="width:120px;" name="probName[]">';
                    probTitle.innerHTML = '';
                 }
                }
                function deleteRow()
                {
                    len = document.getElementById("problemList").rows.length;
                    console.log(len);
                    if(len == 1)
                    {
                       
                         var msg = document.getElementById("msg");
                         msg.innerHTML = "*You have to add atleast one problem.";
                    }
                    else{
                           var msg = document.getElementById("msg");
                     msg.innerHTML = "";
                     document.getElementById("problemList").deleteRow(len-1);
                 }
                }
                </script>
                <table id="problemList">
                <tr>
                    <td>
                         <select id="oj" name="oj[]" style="width:120px;"><option value="SPOJ">SPOJ</option><option value="codeforces">Codeforces</option></select>
                    </td>
                    <td>
                        <input id="probId" type="text" style="width:120px;" placeholder="Problem Id" name="probId[]" onkeyup="crawler(0)">
                    </td>
                    <td>
                        <input type="text" style="width:120px;"  name="probName[]">
                    </td>
                    <td>
                     
                    </td>
                </tr>
                
            </table>
            <h3></h3>
            <br><input type="submit" name="submit" value="Submit" /> 
            </form>
            </div>

    <script>
       
        function crawler(num)
        {
             var serials = ['','A','B', 'C','D', 'E','F', 'G','H', 'I','J', 'K','L', 'M','N', 'O','P', 'Q','R','S', 'T', 'U','V', 'W', 'X','Y', 'Z'];   
            var p = document.getElementsByName('probId[]')[num].value;
            var id = p.toString();
            var len = id.length;
            var oj = document.getElementsByName("oj[]")[num].value;
            var ojName = oj.toString();
            var title = document.getElementsByName("probName[]")[num];
            
            
            console.log(id+" "+ ojName);
            var url;
            if(ojName == "codeforces")
            {
                url = "http://codeforces.com/problemset/problem/";
                var set = id.substring(0, len-1);
                var no = id.substring(len-1, len);
                url+=set+"/"+no; 
                console.log(url);
                

            }
            else if(ojName == "SPOJ")
            {
                url = "http://www.spoj.com/problems/";
                url = url + id +"/";     
             
            }
              var row = document.getElementsByTagName('tr')[num];
                var columnNum = row.cells.length;
                var cell = row.cells.item(columnNum-1);
                xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) 
                {
                  
                           
                        
                        cell.innerHTML = serials[num+1]+" "+ this.responseText;
                        title.value = this.responseText;
                        //document.getElementById(parId).innerHTML = this.responseText;
                }
            };
            xhttp.open("GET", "problemName.php?url="+url, true);
            xhttp.send();   
            
           // document.getElementById("warning_msg").innerHTML = response;
                
        }

        
        
       
        </script>
                    <!--<a href="signup.php" class="button">SIGN UP</a>-->
                    <?php 
                    echo "<br/>Click here to <a href='login.php'>Log In</a></div>";
            } ?>
        </body>
        </html>

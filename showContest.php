<!DOCTYPE html>
<html>
<title>Contest Page</title>
<link rel="icon" type="image/gif" href="logo.png" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="latin.css">
<link rel="stylesheet" href="font-awesome.css">
<link rel="stylesheet"  href="register.css">
<style>
    
body {
    background-image : url("contestBack.jpg");
    font-family: "Lato", sans-serif
}
.mySlides {display: none}
.scroll-left {
 height: 50px;	
 overflow: hidden;
 position: relative;
 
}
.scroll-left p {
 position: absolute;
 width: 100%;
 height: 100%;
 margin: 0;
 line-height: 50px;
 text-align: center;
 /* Starting position */
 -moz-transform:translateX(100%);
 -webkit-transform:translateX(100%);	
 transform:translateX(100%);
 /* Apply animation to this element */	
 -moz-animation: scroll-left 20 linear infinite;
 -webkit-animation: scroll-left 20s linear infinite;
 animation: scroll-left 20s linear infinite;
}
/* Move it (define the animation) */
@-moz-keyframes scroll-left {
 0%   { -moz-transform: translateX(100%); }
 100% { -moz-transform: translateX(-100%); }
}
@-webkit-keyframes scroll-left {
 0%   { -webkit-transform: translateX(100%); }
 100% { -webkit-transform: translateX(-100%); }
}
@keyframes scroll-left {
 0%   { 
 -moz-transform: translateX(100%); /* Browser bug fix */
 -webkit-transform: translateX(100%); /* Browser bug fix */
 transform: translateX(100%); 		
 }
 100% { 
 -moz-transform: translateX(-100%); /* Browser bug fix */
 -webkit-transform: translateX(-100%); /* Browser bug fix */
 transform: translateX(-100%); 
 }
}
.scrolltable {
            
            overflow-x: scroll;
            height: 100%;
            width: 100%;
            display: flex;
            display: -webkit-flex;
            flex-direction: column;
            -webkit-flex-direction: column;
        }
        .scrolltable > .header {
        }
        .scrolltable > .body {
            /*noinspection CssInvalidPropertyValue*/
            width: -webkit-fit-content;
           
            flex: 1;
            -webkit-flex: 1;
        }

        th{
            width: 300px;
        }
        td{
            width:300px;
        }

        /* an outside constraint to react against */
        #constrainer {
            margin:0 auto;
            width: 1000px;
            height: 500px;
        }








        #constrainer2 {
            width: 400px;
            overflow-x: scroll;
        }
        #constrainer2 table {
            overflow-y: scroll;
        }
        #constrainer2 tbody {
            overflow-x: scroll;
            display: block;
            height: 200px;
        }
        #constrainer2 thead {
            display: table-row;
        }




        /* only styling below here */
        #constrainer, #constrainer2 {
            border: 1px solid lightgrey;
        }
        table {
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid gray;
        }
        th {
            background-color: lightgrey;
            border-width: 1px;
        }
        td {
            border-width: 1px;
        }
        tr:first-child td {
            border-top-width: 0;
        }
        tr:nth-child(even) {
            background-color: #eee;
        }

</style>


  
    
    <?php
    error_reporting(E_ERROR | E_PARSE);
    require 'database.php';
      session_start(); 
      global $con;
    ?>

<body>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card-2">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="homepage.php" class="w3-bar-item w3-button w3-padding-large">HOME</a>
    <a href="homepage.php#Status" class="w3-bar-item w3-button w3-padding-large w3-hide-small">STATUS</a>
    <a href="homepage.php#Contests" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTESTS</a>
    <a href="logout.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">LOG OUT</a>
    <a href="profile.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">Welcome, <?php echo $_SESSION["id"];?> !</a>

   <!-- <a href="#contact" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTACT</a>-->
<!--    <div class="w3-dropdown-hover w3-hide-small">
      <button class="w3-padding-large w3-button" title="More">MORE <i class="fa fa-caret-down"></i></button>     
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="#" class="w3-bar-item w3-button">Merchandise</a>
        <a href="#" class="w3-bar-item w3-button">Extras</a>
        <a href="#" class="w3-bar-item w3-button">Media</a>
      </div>
    </div>-->
<!--    <a href="javascript:void(0)" class="w3-padding-large w3-hover-red w3-hide-small w3-right"><i class="fa fa-search"></i></a>-->
  </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
    <a href="homepage.php#Status" class="w3-bar-item w3-button w3-padding-large">Status</a>
    <a href="homepage.php#Contests" class="w3-bar-item w3-button w3-padding-large">TOUR</a>
    <a href="homepage.php#contact" class="w3-bar-item w3-button w3-padding-large">CONTACT</a>
</div>


<div class="w3-padding-64 w3-center w3-opacity w3-white">

    <?php
           date_default_timezone_set('Asia/Bangkok');
        $contestId = $_GET['contestId'];
        $query = "SELECT * from contests WHERE contestId='$contestId'";
        $result = mysqli_query($con, $query);
        if($result)
        {
            $rows = mysqli_fetch_array($result);
            $contestTitle = $rows['contestTitle'];
            $contestStartDate = $rows['contestStartDate'];
            $contestStartTime = $rows['contestStartTime'];
            $contestDuration = $rows['contestDuration'];
            $contestDurationHour = (int)($contestDuration/60);
            $contestDurationMinutes = (int)($contestDuration%60);
            $contestEndDate = $rows['contestEndDate'];
            $contestEndTime = $rows['contestEndTime'];
            $contestDescription= $rows['contestDescription'];
            if($contestDescription == "")
                $contestDescription = "No description available.";
            $contestAnnouncements= $rows['contestAnnouncements'];
            
            $contestStatus = $rows['contestStatus'];
            $datetime = date_create($contestStartDate." ".$contestStartTime);
            $fdatetime = date_format($datetime, "Y-m-d H:i:s");
            $datetime = date_create($fdatetime);

            $startTimestamp = $datetime->getTimestamp();
            
             $datetime = date_create($contestEndDate." ".$contestEndTime);
            $fdatetime = date_format($datetime, "Y-m-d H:i:s");
            $datetime = date_create($fdatetime);
             $endTimestamp = $datetime->getTimestamp();
            if(time()-3600 > $startTimestamp && time()-3600 <$endTimestamp)
            {
                 $contestStatus = '1';
                  $query = "UPDATE contests SET contestStatus = '1' WHERE contestId='$contestId'";
                  $res = mysqli_query($con, $query);
                  
            }
            
           
            if(time()-3600 > $endTimestamp)
            {
                  $contestStatus = '2';
                  $query = "UPDATE contests SET contestStatus = '2' WHERE contestId='$contestId'";
                  $res = mysqli_query($con, $query);
                  
            }
            if($contestStatus == "0")
            {
               $contestStatus = "Not started yet.";
            }
            else if($contestStatus == "1")
            {
               $contestStatus = "Running.";
            }
            else
            {
               $contestStatus = "Ended.";
            }
            
         
            
        }
        
 
      if($contestAnnouncements!="")
      {
          echo "<div class='scroll-left'>
<p>".$contestAnnouncements."</p>
</div>";
      }
      
    echo "<div class='w3-left w3-opacity w3-white'>"
  ."<h5>Begin: ".$contestStartDate." ".$contestStartTime."</h5>"
  . "</div>";
      
   echo "<div class='w3-right w3-opacity w3-white'>"
  ."<h5>End: ".$contestEndDate." ".$contestEndTime."</h5>"
  . "</div>";
  
    
  echo "<h2>".$contestTitle."</h2>";
//  echo "<h5>Description: ".$contestDescription."</h5>";
//  echo "<h5>Announcements: ".$contestAnnouncements."</h5>";
  echo  "<h6>Status: ".$contestStatus."</h6>";
  echo "<h6>Duration: ".$contestDurationHour." hour(s) ".$contestDurationMinutes." minute(s).</h6>";

     
    echo "<html>
<head>
<style>
p {
  text-align: center;
  font-size: 20px;
}
</style>
</head>
<body>

<p id='demo'></p>

<script>
// Set the date we're counting down to
var now = new Date().getTime();
var startDate = new Date('".$contestStartDate." ".$contestStartTime."').getTime();
var endDate = new Date('".$contestEndDate." ".$contestEndTime."').getTime();
if(startDate - now < 0)
{
    var countDownDate = endDate;
     
}
else
    var countDownDate = startDate;
   
console.log(startDate+'hhh');
console.log(endDate);
// Update the count down every 1 second
var x = setInterval(function() {

    // Get todays date and time
    var now = new Date().getTime();
    
    // Find the distance between now an the count down date
    var distance = countDownDate - now;
    console.log(now+'hhh'+countDownDate+'hhhh'+ distance);
    // Time calculations for days, hours, minutes and seconds
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    
    // Output the result in an element with id='demo'
    document.getElementById('demo').innerHTML = days + 'd ' + hours + 'h '
    + minutes + 'm ' + seconds + 's ';
    
    // If the count down is over, write some text 
    if (distance < 0) {
        clearInterval(x);
        document.getElementById('demo').innerHTML = 'EXPIRED';
        
    }
}, 1000);
</script>

</body>
</html>
";

    ?>
   
</div>
<div class="w3-container w3-padding-24 w3-opacity w3-light-blue">
    <div class="w3-bar w3-blue">
     <button class="w3-bar-item w3-button w3-large" onclick="openPage('Overview')">Overview</button>
     <button class="w3-bar-item w3-button w3-large" onclick="openPage('Status')">Status</button>
     <button class="w3-bar-item w3-button w3-large" onclick="openWindow(<?php echo $_GET['contestId']?>)">Rank</button>
    </div>
    
    <div id="Overview" class="page">
        <?php
            
            include 'getSerial.php';
            date_default_timezone_set('Asia/Bangkok');
            $contestId = $_GET['contestId'];
        
        $query = "SELECT * from contests WHERE contestId='$contestId'";
        $result = mysqli_query($con, $query);
        if($result)
        {
            $rows = mysqli_fetch_array($result);
            $contestStartDate = $rows['contestStartDate'];
            $contestStartTime = $rows['contestStartTime'];
            $contestEndDate = $rows['contestEndDate'];
            $contestEndTime = $rows['contestEndTime'];
            $contestDescription = $rows['contestDescription'];
            $setterId = $rows['setterId'];
        } 
        $datetime = date_create($contestStartDate." ".$contestStartTime);
        $fdatetime = date_format($datetime, "Y-m-d H:i:s");
        $datetime = date_create($fdatetime);
       
        $timestamp = $datetime->getTimestamp();
        $query = "SELECT * from contest_problem WHERE contestId='$contestId' ORDER BY serial ASC";
        $result = mysqli_query($con, $query);
       
        if($result)
        {
            
            mysqli_fetch_all($result,MYSQLI_ASSOC);
            $problems = array();
            $i = 0;
            $A = new getSerial();
            foreach($result as $rows)
            {
                 $temp = $rows['problemIdMod'];
                 $problems[$i][0] = $rows['solvecount'];
                 $problems[$i][1] = $A->serialNo($rows['serial']);
                 
                 $query = "SELECT * from problemlist WHERE problemIdMod='$temp'";
                 $res = mysqli_query($con, $query);
                 $info = mysqli_fetch_array($res);
                 $problems[$i][2] = $info['problemName'];
                 $problems[$i][3] = $temp;
                 $i++;
                 
            }
            $total = $i;
        } 
      
        
        if(time()-3600>= $timestamp || $setterId == $_SESSION['id'] )
        {
            
           echo "
                     <table style=' font-family: arial, sans-serif; border-collapse: collapse; width: 100%;'>
                     <tr style='background-color: #1E90FF;'>
                        <th style='border: 1px solid #dddddd; text-align: left;padding: 8px'>#</th>
                         <th style='border: 1px solid #dddddd; text-align: left;padding: 8px'>Title</th>
                        </tr>
                   ";
         for($i = 0; $i< $total; $i++)   
         {
             $url = "showProblem.php?problemIdMod=".$problems[$i][3]."&contestId=".$contestId;
            echo "     <tr style='background-color:#1E90FF;'>
                        <td style='border: 1px solid #dddddd; text-align: left;padding: 8px'>".$problems[$i][1]."</td>
                        <td style='border: 1px solid #dddddd; text-align: left;padding: 8px'><a href='".$url."'>".$problems[$i][2]."</a></td>
                      </tr>";
                    
                    
                    
         }

                   echo "</table>

                    </body>
                    </html>
                    ";
        }
        
        else
        {
            if($contestDescription == "")
                echo "<h3>Description : No description available! </h3>";
            else
                echo  "<h3>Description: ".$contestDescription."</h3>";
            echo "<h3>Please come back once the contest starts!</h3>";
        }
           
        ?>
 
    </div>



<div id="Status" class="page" style="display:none">
   <div id="constrainer" class="w3-center">
                     <div class="scrolltable">
                        <table class="header"><thead><th>Contest Id</th><th>Submission Id</th><th>User Id</th><th>#</th><th>Problem Id</th><th>Verdict</th><th>Submission Time</th></thead></table>
                            <div class="body">
                               <table>
                                    <tbody>
        <?php
        $contestId = $_GET['contestId'];
        $qry = "SELECT * from contest_submission WHERE contestId='$contestId'";
        $result = mysqli_query($con, $qry);
        if($result)
        {
            mysqli_fetch_all($result,MYSQLI_ASSOC);
            $submissions= array();
            $i = 0;
            foreach($result as $rows)
            {
                $submissions[$i][0] = $rows['contestId'];
                $submissions[$i][1] = $rows['submissionId'];
                $submissions[$i][3] = $rows['serial'];
                $submissions[$i][2] = $rows['userId'];
                $submissions[$i][4] = $rows['problemIdMod'];
                $submissions[$i][5] = $rows['verdict'];
                $submissions[$i][6] = $rows['submissionTime'];
                $i++;
            }
            $total = $i;
        }
      
        for($i = 0; $i<$total; $i++)
        {

            echo '<tr><td>'.$submissions[$i][0].'</td><td>'.$submissions[$i][1].'</td><td>'.$submissions[$i][2].'</td><td>'.$submissions[$i][3].'</td><td>'.$submissions[$i][4].'</td><td>'.$submissions[$i][5].'</td><td>'.$submissions[$i][6].'</td></tr>';
        }
           ?>
               </tbody>
            </table>
        </div>
    </div>
</div>
</div>
    

    
</div>
<script>
    function openPage(pageName) 
    {
        var i;
        var x = document.getElementsByClassName("page");
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none"; 
        }
        console.log(document.getElementById(pageName).value);
        document.getElementById(pageName).style.display = "block"; 
    }
    
    function openWindow(contestId)
    {
        window.open('ranklist.php?contestId='+contestId);
    }

</script>

 
<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
 <p class="w3-medium">Powered by <a href="https://csedu.du.ac.bd" target="_blank">CSEDU</a></p>
</footer>
<script>
// Automatic Slideshow - change image every 4 seconds
var myIndex = 0;
carousel();

function carousel() {
    var i;
    var x = document.getElementsByClassName("mySlides");
    for (i = 0; i < x.length; i++) {
       x[i].style.display = "none";  
    }
    myIndex++;
    if (myIndex > x.length) {myIndex = 1}    
    x[myIndex-1].style.display = "block";  
    setTimeout(carousel, 4000);    
}

// Used to toggle the menu on small screens when clicking on the menu button
function myFunction() {
    var x = document.getElementById("navDemo");
    if (x.className.indexOf("w3-show") == -1) {
        x.className += " w3-show";
    } else { 
        x.className = x.className.replace(" w3-show", "");
    }
}

// When the user clicks anywhere outside of the modal, close it
var modal = document.getElementById('ticketModal');
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
}
</script>

</body>
</html>

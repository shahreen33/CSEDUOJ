<!DOCTYPE html>
<html>
<title>Home</title>
<link rel="icon" type="image/gif" href="logo.png" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="latin.css">
<link rel="stylesheet" href="font-awesome.css">
<link rel="stylesheet"  href="register.css">
<style>
body {font-family: "Lato", sans-serif}
.mySlides {display: none}
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
    border-radius: 0px ; 
}

/* Modal Content */
.modal-content {
    position: relative;
    background-color: #fefefe;
    margin: auto;
    padding: 0;
    border: 1px solid #888;

    width: 80%;
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2),0 6px 20px 0 rgba(0,0,0,0.19);
    -webkit-animation-name: animatetop;
    -webkit-animation-duration: 0.4s;
    animation-name: animatetop;
    animation-duration: 0.4s
}

/* Add Animation */
@-webkit-keyframes animatetop {
    from {top:-300px; opacity:0} 
    to {top:0; opacity:1}
}

@keyframes animatetop {
    from {top:-300px; opacity:0}
    to {top:0; opacity:1}
}

/* The Close Button */
.close {
    color: white;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}

.modal-header {
    padding: 2px 16px;
    background-color: black;
    color: white;
}

.modal-body {padding: 2px 16px;}

.modal-footer {
    padding: 2px 16px;
    background-color: black;
    color: white;
}
 .scrolltable {
             margin:0 auto;
            overflow-x: scroll;
            height: 100%;
            width: 1050px;
            display: flex;
            display: -webkit-flex;
            flex-direction:column;
            -webkit-flex-direction: column;
        }
        .scrolltable > .header {
        }
        .scrolltable > .body {
            /*noinspection CssInvalidPropertyValue*/
             overflow-y: scroll;
            width: -webkit-fit-content;
            flex: 1;
            -webkit-flex: 1;
        }

      th, td {
            width: 350px;
        }


        /* an outside constraint to react against */
        #constrainer {
            position: relative;
            right:15%;
            width: 1050px;
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
    require 'database.php';
      session_start(); 
  
    ?>

<body>

<!-- Navbar -->
<div class="w3-top">
   
  <div class="w3-bar w3-black w3-card-2">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="#" class="w3-bar-item w3-button w3-padding-large">HOME</a>
    <a href="#Problems" class="w3-bar-item w3-button w3-padding-large w3-hide-small">PROBLEMS</a>
    <a href="#Contests" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTESTS</a>
    <a href="#Status" class="w3-bar-item w3-button w3-padding-large w3-hide-small">STATUS</a>
    <a href="logout.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">LOG OUT</a>
    <button id="profile" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">Welcome, <?php echo $_SESSION["id"];?> !</button>

       <div id="profileModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2 style="color:white">Profile</h2>
    </div>
    <div class="modal-body">
        <table>
            <th></th><th></th>
     <?php
     $id = $_SESSION['id'];
     echo $id;
     $qry = "SELECT * from users where id='$id'";
     $res = mysqli_query($con, $qry);
     $row = mysqli_fetch_array($res);
     $name = $row['name'];
     $email= $row['email'];
     $password = $row['password'];
     echo '<tr><td><b style="color:black">Name</b></td><td><a style="color:black">'.$name.'</a></td></tr>
         <tr><td><b style="color:black">Email</b></td><td><a style="color:black">'.$email.'<a/></td></tr>
         <tr><td><b style="color:black">Password</b></td><td><a style="color:black" href=changePassword.php?id='.$id.'>Change Password</td></tr>
          ';   
     ?>
</table></div>';

         <div class="modal-footer" style="height:50px">

    </div>     
    
    </div>
 
  </div>

</div>

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


<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
 <a href="#Contests" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTESTS</a>
    <a href="#Status" class="w3-bar-item w3-button w3-padding-large w3-hide-small">STATUS</a>
    <a href="logout.php" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">LOG OUT</a>
    <button id="profile" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">Welcome, <?php echo $_SESSION["id"];?> !</button>
</div>

<div class="w3-content" style="max-width:2000px;margin-top:40px">
  <!-- Automatic Slideshow Images -->
  
  <div class="w3-container w3-white">
   <img src="logo.png" style="width:7%; height: 100px; float:left">
   <img src="header.png" style="height:100px; float:left">
  <img src="icon2.jpg" style=" width: 10% ;height:100px; float:right">
    </div>
  <div class="mySlides w3-display-container w3-center">
      <img src="wf1.jpg" style="width:100%; height: 800px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>World Finalists of CSEDU</h3>
    </div>
  </div>
  
  <div class="mySlides w3-display-container w3-center">
      <img src="gryffindor.jpg" style="width:100%; height: 800px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>World Finalists of CSEDU</h3>
    </div>
  </div>
  
  <div class="mySlides w3-display-container w3-center">
      <img src="wf2.jpg" style="width:100%; height: 800px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>World Finalists of CSEDU</h3>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
    <img src="wf3.jpg" style="width:100% ; height: 800px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>World Finalists of CSEDU</h3>
    </div>
  </div>
      <div class="mySlides w3-display-container w3-center">
          <img src="resonance.jpg" style="width:100% ; height: 800px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>DU Resonance</h3>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
      <img src="contest.jpg" style="width:100%; height: 800px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>Battle of Brains</h3>
    </div>
  </div>
   <div class="mySlides w3-display-container w3-center">
      <img src="contest1.jpg" style="width:100%; height: 800px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>Battle of Brains</h3>  
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
      <img src="contest5.jpg" style="width:100%; height: 800px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>Battle of Brains</h3>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
    <img src="contest6.jpg" style="width:100%; height: 800px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">

    </div>
  </div>
  </div>
  <!-- The Band Section -->
  <div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px" id="Problems">
    <h2 class="w3-wide">Problems</h2>
    <div id="constrainer" class="w3-center">
                     <div class="scrolltable">
                        <table class="header"><thead><th>Problem Id</th><th>Problem Name</th><th>Problem Link</th></thead></table>
                            <div class="body">
                               <table>
                                    <tbody>
        <?php
        $qry = "SELECT * from problemlist";
        $result = mysqli_query($con, $qry);
        if($result)
        {
            mysqli_fetch_all($result,MYSQLI_ASSOC);
            $problems = array();
            $i = 0;
            foreach($result as $rows)
            {
                $problems[$i][0] = $rows['problemId'];
                $problems[$i][1] = $rows['oj'];
                $problems[$i][2] = $rows['problemName'];
                $problems[$i][3] = $rows['problemIdMod'];
                $i++;
            }
            $total = $i;
        }
        
      
     
    

                for($i = 0; $i<$total; $i++)
                {
                    $url = 'showProblem.php?problemIdMod='.$problems[$i][3].'&contestId=';
                    echo '<tr><td>'.$problems[$i][0].'</td><td>'.$problems[$i][2].'</td><td><a href="'.$url.'">Open</a></td></tr>';
                }
           ?>
               </tbody>
            </table>
        </div>
    </div>
</div>';
   
      </div>;
                
  

  <!-- The Tour Section -->
    <div class="w3-black" id="Contests">
   <div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px" id="Problems">
       <a href="createContest.php" class="w3-button w3-padding-large w3-hide-small w3-right">Create Contest</a>
    <h2 class="w3-wide">Contests</h2>
    <div id="constrainer" class="w3-center">
        <div class="scrolltable">
            <table class="header"><thead><th>Contest Id</th><th>Title</th><th>Begin</th><th>End</th><th>Duration</th><th>Status</th><th>Setter Id</th></thead></table>
                <div class="body">
                    <table>
                       <tbody>
        <?php
        $qry = "SELECT * from contests";
        $result = mysqli_query($con, $qry);
        if($result)
        {
            mysqli_fetch_all($result,MYSQLI_ASSOC);
            $contests = array();
            $i = 0;
            foreach($result as $rows)
            {
                $contests[$i][0] = $rows['contestId'];
                $contests[$i][1] = $rows['contestTitle'];
                $contests[$i][2] = $rows['contestStartDate'];
                $contests[$i][3] = $rows['contestStartTime'];
                $contests[$i][4] = $rows['contestEndDate'];
                $contests[$i][5] = $rows['contestEndTime'];
                $contests[$i][6] = $rows['contestDuration'];
                $contests[$i][7] = $rows['contestStatus'];
                $contests[$i][8] = $rows['setterId'];
                
                $temp = $contests[$i][6];
                $contestDurationHour = $temp / 60;
                $contestDurationMinutes = $temp % 60;
                $contests[$i][6] = $contestDurationHour.' hr '.$contestDurationMinutes.' min';
                
                $i++;
            }
            $total = $i;
        }
        
      
     
    

                for($i = 0; $i<$total; $i++)
                {
                    $url = 'showContest.php?contestId='.$contests[$i][0];
                    echo '<tr><td><a href="'.$url.'">'.$contests[$i][0].'</a></td><td><a href="'.$url.'">'.$contests[$i][1].'</a></td><td>'.$contests[$i][2].' '.$contests[$i][3].'</td><td>'.$contests[$i][4].' '.$contests[$i][5].'</td><td>'.$contests[$i][6].'</td><td>'.$contests[$i][7].'</td><td>'.$contests[$i][8].'</td></tr>';
                }
           ?>
               </tbody>
            </table>
        </div>
    </div>
</div>
   
      </div>
            
 
  </div>


<div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px" id="Status">
    <h2 class="w3-wide">Status</h2>
    <div id="constrainer" class="w3-center">
                     <div class="scrolltable">
                        <table class="header"><thead><th>Contest Id</th><th>Submission Id</th><th>User Id</th><th>#</th><th>Problem Id</th><th>Verdict</th><th>Submission Time</th></thead></table>
                            <div class="body">
                               <table>
                                    <tbody>
        <?php
        $qry = "SELECT * from contest_submission";
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
  

<!-- Footer -->
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
  <i class="fa fa-facebook-official w3-hover-opacity"></i>
  <i class="fa fa-instagram w3-hover-opacity"></i>
  <i class="fa fa-snapchat w3-hover-opacity"></i>
  <i class="fa fa-pinterest-p w3-hover-opacity"></i>
  <i class="fa fa-twitter w3-hover-opacity"></i>
  <i class="fa fa-linkedin w3-hover-opacity"></i>
  <p class="w3-medium">Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
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

var modal = document.getElementById('profileModal');

// Get the button that opens the modal
var btn = document.getElementById("profile");

// Get the <span> element that closes the modal

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal

// When the user clicks anywhere outside of the modal, close it


window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
    
}
</script>

</body>
</html>

<!DOCTYPE html>
<html>
<title>CSEDU Online Judge - Home</title>
<link rel="icon" type="image/gif" href="logo.png" />
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="latin.css">
<link rel="stylesheet" href="font-awesome.css">
<link rel="stylesheet" href="register.css">
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
    background-color: #5cb85c;
    color: white;
}


</style>
    <?php
    require 'database.php';
    require 'authorize.php';
  
    ?>
<body>
   

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-black w3-card-2">
    <a class="w3-bar-item w3-button w3-padding-large w3-hide-medium w3-hide-large w3-right" href="javascript:void(0)" onclick="myFunction()" title="Toggle Navigation Menu"><i class="fa fa-bars"></i></a>
    <a href="#" class="w3-bar-item w3-button w3-padding-large">HOME</a>
    <a href="#Status" class="w3-bar-item w3-button w3-padding-large w3-hide-small">STATUS</a>
    <a href="#Contests" class="w3-bar-item w3-button w3-padding-large w3-hide-small">CONTESTS</a>
    <button id="register" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">REGISTER</button>
     <button id="login" class="w3-bar-item w3-button w3-padding-large w3-hide-small w3-right">LOG IN</button>

<!-- Trigger/Open The Modal -->
   

<!-- The Modal -->
<div id="registerModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2 style="color:white">Register</h2>
    </div>
    <div class="modal-body">
       
                <div class="form">
                <form name="registration" action="register.php" method="post">
                <br> <input type="text" name="name" placeholder="Name" required /><br>
                <br> <input type="text" name="id" placeholder="ID" required /><br>
                <br><input type="email" name="email" placeholder="Email" required /><br>
                <br><input id ="password" type="password" onkeyup="passwordValidator()"  name="password" placeholder="Password" required />
                <p id="warning_msg" style="color:black"></p><br>
                <br><input type="submit" style="background-color:black" name="submit" value="Submit" /> 
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
    </div>
  
  </div>

</div>

<div id="loginModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2 style="color:white">Log In</h2>
    </div>
    <div class="modal-body">
     
            <div class="form">
            <h2>Log In</h2>
            <form name="login" action="login.php" method="post">
            <br> <input type="text" name="id" placeholder="ID" required /><br>
            <br><input type="password" name="password" placeholder="Password" required /><br>
            <br><input type="submit" name="submit" value="Submit" /> 
            </form>
            </div>
            <!--<a href="signup.php" class="button">SIGN UP</a>-->
           
            <br/>Click here to <a href='index.php'>register</a>;
    
    </div>
  
  </div>

</div>

  </div>
</div>

<!-- Navbar on small screens -->
<div id="navDemo" class="w3-bar-block w3-black w3-hide w3-hide-large w3-hide-medium w3-top" style="margin-top:46px">
  <a href="#Status" class="w3-bar-item w3-button w3-padding-large">Status</a>
  <a href="#Contests" class="w3-bar-item w3-button w3-padding-large">TOUR</a>
  <a href="#contact" class="w3-bar-item w3-button w3-padding-large">CONTACT</a>
  <a href="#" class="w3-bar-item w3-button w3-padding-large">MERCH</a>
</div>

<!-- Page content -->

<div class="w3-content" style="max-width:2000px;margin-top:40px">
  <!-- Automatic Slideshow Images -->
  
  <img src="logo.png" style="width:7%; height: 100px; float:left">
  <img src="header.png" style="height:100px; float:left">
  <img src="icon2.jpg" style=" width: 10% ;height:100px; float:right">
  <div class="mySlides w3-display-container w3-center">
      <img src="wf1.jpg" style="width:100%; height: 700px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>World Finalists of CSEDU</h3>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
      <img src="wf2.jpg" style="width:100%; height: 700px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>World Finalists of CSEDU</h3>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
    <img src="wf3.jpg" style="width:100% ; height: 700px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>World Finalists of CSEDU</h3>
    </div>
  </div>
      <div class="mySlides w3-display-container w3-center">
          <img src="resonance.jpg" style="width:100% ; height: 700px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>DU Resonance</h3>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
      <img src="contest.jpg" style="width:100%; height: 700px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>Battle of Brains</h3>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
    <img src="contest7.jpg" style="width:100%; height: 700px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>Battle of Brains</h3>
    </div>
  </div>
   <div class="mySlides w3-display-container w3-center">
      <img src="contest1.jpg" style="width:100%; height: 700px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>Battle of Brains</h3>  
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
      <img src="contest5.jpg" style="width:100%; height: 700px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">
      <h3>Battle of Brains</h3>
    </div>
  </div>
  <div class="mySlides w3-display-container w3-center">
    <img src="contest6.jpg" style="width:100%; height: 700px">
    <div class="w3-display-bottommiddle w3-container w3-text-white w3-padding-32 w3-hide-small">

    </div>
  </div>
  </div>


  <!-- The Band Section -->
  <div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px" id="Status">
    <h2 class="w3-wide">Status</h2>
    <p class="w3-opacity"><i>We love music</i></p>
    <p class="w3-justify">We have created a fictional Status website. Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip
      ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum consectetur
      adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
    <div class="w3-row w3-padding-32">
      <div class="w3-third">
        <p>Name</p>
        <img src="/w3images/Statusmember.jpg" class="w3-round w3-margin-bottom" alt="Random Name" style="width:60%">
      </div>
      <div class="w3-third">
        <p>Name</p>
        <img src="/w3images/Statusmember.jpg" class="w3-round w3-margin-bottom" alt="Random Name" style="width:60%">
      </div>
      <div class="w3-third">
        <p>Name</p>
        <img src="/w3images/Statusmember.jpg" class="w3-round" alt="Random Name" style="width:60%">
      </div>
    </div>
  </div>

  <!-- The Tour Section -->
  <div class="w3-black" id="Contests">
    <div class="w3-container w3-content w3-padding-64" style="max-width:800px">
      <h2 class="w3-wide w3-center">TOUR DATES</h2>
      <p class="w3-opacity w3-center"><i>Remember to book your tickets!</i></p><br>

      <ul class="w3-ul w3-border w3-white w3-text-grey">
        <li class="w3-padding">September <span class="w3-tag w3-red w3-margin-left">Sold out</span></li>
        <li class="w3-padding">October <span class="w3-tag w3-red w3-margin-left">Sold out</span></li>
        <li class="w3-padding">November <span class="w3-badge w3-right w3-margin-right">3</span></li>
      </ul>

      <div class="w3-row-padding w3-padding-32" style="margin:0 -16px">
        <div class="w3-third w3-margin-bottom">
          <img src="/w3images/newyork.jpg" alt="New York" style="width:100%" class="w3-hover-opacity">
          <div class="w3-container w3-white">
            <p><b>New York</b></p>
            <p class="w3-opacity">Fri 27 Nov 2016</p>
            <p>Praesent tincidunt sed tellus ut rutrum sed vitae justo.</p>
            <button class="w3-button w3-black w3-margin-bottom" onclick="document.getElementById('ticketModal').style.display='block'">Buy Tickets</button>
          </div>
        </div>
        <div class="w3-third w3-margin-bottom">
          <img src="/w3images/paris.jpg" alt="Paris" style="width:100%" class="w3-hover-opacity">
          <div class="w3-container w3-white">
            <p><b>Paris</b></p>
            <p class="w3-opacity">Sat 28 Nov 2016</p>
            <p>Praesent tincidunt sed tellus ut rutrum sed vitae justo.</p>
            <button class="w3-button w3-black w3-margin-bottom" onclick="document.getElementById('ticketModal').style.display='block'">Buy Tickets</button>
          </div>
        </div>
        <div class="w3-third w3-margin-bottom">
          <img src="/w3images/sanfran.jpg" alt="San Francisco" style="width:100%" class="w3-hover-opacity">
          <div class="w3-container w3-white">
            <p><b>San Francisco</b></p>
            <p class="w3-opacity">Sun 29 Nov 2016</p>
            <p>Praesent tincidunt sed tellus ut rutrum sed vitae justo.</p>
            <button class="w3-button w3-black w3-margin-bottom" onclick="document.getElementById('ticketModal').style.display='block'">Buy Tickets</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Ticket Modal -->
  <div id="ticketModal" class="w3-modal">
    <div class="w3-modal-content w3-animate-top w3-card-4">
      <header class="w3-container w3-teal w3-center w3-padding-32"> 
        <span onclick="document.getElementById('ticketModal').style.display='none'" 
       class="w3-button w3-teal w3-xlarge w3-display-topright">×</span>
        <h2 class="w3-wide"><i class="fa fa-suitcase w3-margin-right"></i>Tickets</h2>
      </header>
      <div class="w3-container">
        <p><label><i class="fa fa-shopping-cart"></i> Tickets, $15 per person</label></p>
        <input class="w3-input w3-border" type="text" placeholder="How many?">
        <p><label><i class="fa fa-user"></i> Send To</label></p>
        <input class="w3-input w3-border" type="text" placeholder="Enter email">
        <button class="w3-button w3-block w3-teal w3-padding-16 w3-section w3-right">PAY <i class="fa fa-check"></i></button>
        <button class="w3-button w3-red w3-section" onclick="document.getElementById('ticketModal').style.display='none'">Close <i class="fa fa-remove"></i></button>
        <p class="w3-right">Need <a href="#" class="w3-text-blue">help?</a></p>
      </div>
    </div>
  </div>

  <!-- The Contact Section -->
  <div class="w3-container w3-content w3-padding-64" style="max-width:800px" id="contact">
    <h2 class="w3-wide w3-center">CONTACT</h2>
    <p class="w3-opacity w3-center"><i>Fan? Drop a note!</i></p>
    <div class="w3-row w3-padding-32">
      <div class="w3-col m6 w3-large w3-margin-bottom">
        <i class="fa fa-map-marker" style="width:30px"></i> Chicago, US<br>
        <i class="fa fa-phone" style="width:30px"></i> Phone: +00 151515<br>
        <i class="fa fa-envelope" style="width:30px"> </i> Email: mail@mail.com<br>
      </div>
      <div class="w3-col m6">
        <form action="/action_page.php" target="_blank">
          <div class="w3-row-padding" style="margin:0 -16px 8px -16px">
            <div class="w3-half">
              <input class="w3-input w3-border" type="text" placeholder="Name" required name="Name">
            </div>
            <div class="w3-half">
              <input class="w3-input w3-border" type="text" placeholder="Email" required name="Email">
            </div>
          </div>
          <input class="w3-input w3-border" type="text" placeholder="Message" required name="Message">
          <button class="w3-button w3-black w3-section w3-right" type="submit">SEND</button>
        </form>
      </div>
    </div>
  </div>
  
<!-- End Page Content -->

<!-- Add Google Maps -->

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
    setTimeout(carousel, 3000);    
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
// Get the modal
var modal1 = document.getElementById('registerModal');

// Get the button that opens the modal
var btn1 = document.getElementById("register");

// Get the <span> element that closes the modal

// When the user clicks the button, open the modal 
btn1.onclick = function() {
    modal1.style.display = "block";
}

// When the user clicks on <span> (x), close the modal

// When the user clicks anywhere outside of the modal, close it


var modal2 = document.getElementById('loginModal');

// Get the button that opens the modal
var btn2 = document.getElementById("login");


// When the user clicks the button, open the modal 
btn2.onclick = function() {
    modal2.style.display = "block";
}


window.onclick = function(event) {
    if (event.target == modal1) {
        modal1.style.display = "none";
    }
     if (event.target == modal2) {
        modal2.style.display = "none";
    }
}

// When the user clicks on <span> (x), close the modal


// When the user clicks anywhere outside of the modal, close it

</script>

</body>
</html>

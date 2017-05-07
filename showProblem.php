<!DOCTYPE html>
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
         <img src="other.png" style="width: 100%">
<?php
require('database.php');
include('problem.php');
session_start();
global $con;
    $problemIdMod = $_GET['problemIdMod'];
    $contestId = $_GET['contestId'];
     $qry = "SELECT * from problemlist WHERE problemIdMod = '$problemIdMod'";
        $result = mysqli_query($con, $qry);
        if($result)
        {
            $rows = mysqli_fetch_array($result);
           
                $problemId = $rows['problemId'];
                $oj = $rows['oj'];
                $problemName= $rows['problemName'];
                
                
            
        }
    if($oj == 'SPOJ')
    {
        $url = "http://www.spoj.com/problems/".$problemId."/";
        
    }
    else if($oj == "codeforces")
    {
         $url = "http://codeforces.com/problemset/problem/";
         $len = strlen($problemId);
         $set = substr($problemId, 0, $len-1);
         $no = substr($problemId, $len-1, 1);
         $url = $url.$set."/".$no;
         
    }
        
    $currentProblem = new problem($url);
    $currenProblemHtml = $currentProblem->getProblemBody();
    
    echo '<h3>'.$problemName.'</h3>';
    if($contestId == '')
    {}
    else{
    echo ' <button id="submit" style="background-color:black" class="w3-button w3-padding-large w3-hide-small w3-right"><b style="color:white">Submit Solution!</b></button>'
    . '<div id="submitModal" class="modal">

  <!-- Modal content -->
  <div class="modal-content">
    <div class="modal-header">
      <h2 style="color:white">Submit solution</h2>
    </div>
    <div class="modal-body">
     
            <div class="form" id="submitCode"> 
            <form name="submitSolution" action="submitComplete.php" method="post">
            <br> <input type="text" name="contestId" value="'.$contestId.'" required /><br>
            <br> <input type="text" name="problemIdMod" value="'.$problemIdMod.'" required /><br>
            <br> <textarea class="form-control" name="code" id="submit-solution" rows="15" placeholder="At least 50 characters"></textarea> <br>
            <select name="lang" id="lang" class="form-control">
												<option value="7">Ada95 (gnat 6.3)</option>
												<option value="59">Any document (no testing)</option>
												<option value="13">Assembler 32 (nasm 2.12.01)</option>
												<option value="45">Assembler 32 (gcc 6.3 )</option>
												<option value="42">Assembler 64 (nasm 2.12.01)</option>
												<option value="105">AWK (mawk 1.3.3)</option>
												<option value="104">AWK (gawk 4.1.3)</option>
												<option value="28">Bash (bash 4.4.5)</option>
												<option value="110">BC (bc 1.06.95)</option>
												<option value="12">Brainf**k (bff 1.0.6)</option>
												<option value="81">C (clang 4.0)</option>
												<option value="11">C (gcc 6.3)</option>
												<option value="27">C# (gmcs 4.6.2)</option>
												<option value="1">C++ (gcc 6.3)</option>
												<option value="41">C++ (g++ 4.3.2)</option>
												<option value="82">C++14 (clang 4.0)</option>
												<option value="44">C++14 (gcc 6.3)</option>
												<option value="34">C99 (gcc 6.3)</option>
												<option value="14">Clips (clips 6.24)</option>
												<option value="111">Clojure (clojure 1.8.0)</option>
												<option value="118">Cobol (opencobol 1.1.0)</option>
												<option value="91">CoffeeScript (coffee 1.12.2)</option>
												<option value="31">Common Lisp (sbcl 1.3.13)</option>
												<option value="32">Common Lisp (clisp 2.49)</option>
												<option value="102">D (dmd 2.072.2)</option>
												<option value="84">D (ldc 1.1.0)</option>
												<option value="20">D (gdc 6.3)</option>
												<option value="48">Dart (dart 1.21)</option>
												<option value="96">Elixir (elixir 1.3.3)</option>
												<option value="36">Erlang (erl 19)</option>
												<option value="124">F# (mono 4.0.0)</option>
												<option value="92">Fantom (fantom 1.0.69)</option>
												<option value="107">Forth (gforth 0.7.3)</option>
												<option value="5">Fortran (gfortran 6.3)</option>
												<option value="114">Go (go 1.7.4)</option>
												<option value="98">Gosu (gosu 1.14.2)</option>
												<option value="121">Groovy (groovy 2.4.7)</option>
												<option value="21">Haskell (ghc 8.0.1)</option>
												<option value="16">Icon (iconc 9.5.1)</option>
												<option value="9">Intercal (ick 0.3)</option>
												<option value="24">JAR (JavaSE 6)</option>
												<option value="10">Java (HotSpot 8u112)</option>
												<option value="112">JavaScript (SMonkey 24.2.0)</option>
												<option value="35">JavaScript (rhino 1.7.7)</option>
												<option value="47">Kotlin (kotlin 1.0.6)</option>
												<option value="26">Lua (luac 5.3.3)</option>
												<option value="30">Nemerle (ncc 1.2.0)</option>
												<option value="25">Nice (nicec 0.9.13)</option>
												<option value="122">Nim (nim 0.16.0)</option>
												<option value="56">Node.js (node 7.4.0)</option>
												<option value="43">Objective-C (gcc 6.3)</option>
												<option value="83">Objective-C (clang 4.0)</option>
												<option value="8">Ocaml (ocamlopt 4.01)</option>
												<option value="127">Octave (octave 4.0.3)</option>
												<option value="22">Pascal (fpc 3.0.0)</option>
												<option value="2">Pascal (gpc 20070904)</option>
												<option value="60">PDF (ghostscript 8.62)</option>
												<option value="3">Perl (perl 5.24.1)</option>
												<option value="54">Perl (perl 6)</option>
												<option value="29">PHP (php 7.1.0)</option>
												<option value="94">Pico Lisp (pico 16.12.8)</option>
												<option value="19">Pike (pike 8.0)</option>
												<option value="61">PostScript (ghostscript 8.62)</option>
												<option value="15">Prolog (swi 7.2.3)</option>
												<option value="108">Prolog (gnu prolog 1.4.5)</option>
												<option value="4">Python (cpython 2.7.13)</option>
												<option value="99">Python (PyPy 2.6.0)</option>
												<option value="116">Python 3 (python  3.5)</option>
												<option value="126">Python 3 nbc (python 3.4)</option>
												<option value="117">R (R 3.3.2)</option>
												<option value="95">Racket (racket 6.7)</option>
												<option value="17">Ruby (ruby 2.3.3)</option>
												<option value="93">Rust (rust 1.14.0)</option>
												<option value="39">Scala (scala 2.12.1)</option>
												<option value="33">Scheme (guile 2.0.13)</option>
												<option value="18">Scheme (stalin 0.3)</option>
												<option value="97">Scheme (chicken 4.11.0)</option>
												<option value="46">Sed (sed 4)</option>
												<option value="23">Smalltalk (gst 3.2.5)</option>
												<option value="40">SQLite (sqlite 3.16.2)</option>
												<option value="85">Swift (swift 3.0.2)</option>
												<option value="38">TCL (tcl 8.6)</option>
												<option value="62">Text (plain text)</option>
												<option value="115">Unlambda (unlambda 0.1.4.2)</option>
												<option value="50">VB.net (mono 4.6.2)</option>
												<option value="6">Whitespace (wspace 0.3)</option>
												</select>
            <br><input type="submit" name="submit" value="Submit" /> 
            </form>
            
            </div>
            <!--<a href="signup.php" class="button">SIGN UP</a>-->
           
            <br/>Click here to <a href=index.php>register</a>;
    
    </div>
  
  </div>

</div>
     <script>
  var modal = document.getElementById("submitModal");

// Get the button that opens the modal
var btn = document.getElementById("submit");

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
    
     </script>';
    }
    echo $currenProblemHtml;

    
      
?>

 </body>
</html>

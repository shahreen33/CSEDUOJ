<!DOCTYPE html>
<html>
<head>
<link rel="icon" type="image/gif" href="logo.png" />
<meta charset="utf-8">
<link rel="stylesheet" href="addProblem.css">
<link rel="stylesheet" href="w3.css">
<link rel="stylesheet" href="latin.css">
<link rel="stylesheet" href="font-awesome.css">
<title>Ranklist</title>
</head>
<body>
    
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
         <img src="other.png" style="width: 100%">
         <div class="w3-container w3-content w3-center w3-padding-64" style="max-width:800px">
     
            
<?php
error_reporting(E_ERROR | E_PARSE);
require('database.php');
include('problem.php');
include 'contestant.php';
include 'getSerial.php';
session_start();
global $con;
   
    function comp($contestantA, $contestantB)
    {
        if($contestantA->ACCount == $contestantB->ACCount)
        {
            if($contestantA->penalty < $contestantB->penalty)
                return -1;
            else if($contestantA->penalty == $contestantB->penalty)
                return 0;
            else 
                return 1;
            
        }
        
        else if($contestantA->ACCount > $contestantB->ACCount)
        {
            return -1;
        }
        else
            return 1;
    }
    $contestId = $_GET['contestId'];
    $qry = "SELECT * from contests WHERE contestId= '$contestId'";
    $res = mysqli_query($con, $qry);
    if($res)
    {
                    $row = mysqli_fetch_array($res);
                    $contestStartDate = $row['contestStartDate'];
                    $contestStartTime = $row['contestStartTime'];
                    $contestEndDate = $row['contestEndDate'];
                    $contestEndTime = $row['contestEndTime'];
                    $contestTitle = $row['contestTitle'];
                    $datetime = date_create($contestStartDate." ".$contestStartTime);
                    $fdatetime = date_format($datetime, "Y-m-d H:i:s");
                    $datetime = date_create($fdatetime);

                    $startTimestamp = $datetime->getTimestamp();

                    $datetime = date_create($contestEndDate." ".$contestEndTime);
                    $fdatetime = date_format($datetime, "Y-m-d H:i:s");
                    $datetime = date_create($fdatetime);
                    
                    $endTimestamp = $datetime->getTimestamp();
                    
                    
                    $qry = "SELECT * from contest_submission WHERE contestId= '$contestId'";
                    $result = mysqli_query($con, $qry);
                    
                    if($result)
                    {
                            
                            $contestants = array();
                            
                            mysqli_fetch_all($result,MYSQLI_ASSOC);

                            foreach($result as $submissions)
                            {
                                $userId = $submissions['userId'];
                                $serial= $submissions['serial'];
                                $submissionTime = $submissions['submissionTime'];
                                $verdict = $submissions['verdict'];
                                $datetime = date_create($submissionTime);
                                $fdatetime = date_format($datetime, "Y-m-d H:i:s");
                                $datetime = date_create($fdatetime);

                                $submissionTimestamp = $datetime->getTimestamp();
                                
                                if($submissionTimestamp > $endTimestamp || $verdict == 'Submission Failed')
                                    continue;
                               
                                $submissionTimestamp-=$startTimestamp;
                                $currAttempt = new attempt($serial, $verdict, $submissionTimestamp);
                                if(!array_key_exists($userId, $contestants))
                                {
                                         $contestants[$userId] = new contestant;
                                         $contestants[$userId]->contestantId = $userId;
                                }
                                $contestants[$userId]->addAttempt($currAttempt);
                            }
                            foreach($contestants as $temp)
                            {
                                $temp->calculate();
                            }
                            
                            usort($contestants,"comp");
                            

                    }


                  
                   
                   echo '  <h2 class="w3-wide" style="color:black">'.$contestTitle.'</h2>
                            <div id="constrainer" class="w3-center">
                                <div class="scrolltable">';
                   $qry = "SELECT * from contest_problem WHERE contestId='$contestId'";
                   $r = mysqli_query($con, $qry);
                   $count = mysqli_num_rows($r);
                   $newSerial = new getSerial;
                   echo '<table class="header"><thead><th>Rank</th><th>Team/Contestant</th><th>Solved</th><th>Penalty</th>';
                   for($i = 0; $i< $count ; $i++)
                   {
                            echo '<th>'.$newSerial->serialNo($i+1).'</th>';
                   } 
                   echo '</thead></table>
                       <div class="body">
                    <table>
                       <tbody>';
                   
                   
               $rank = 1;
               $serials = 0;
               foreach($contestants as $temp)
                {
                    echo '<tr><td>'.$rank.'</td><td>'.$temp->contestantId.'</td><td>'.$temp->ACCount.'</td><td>'.$temp->penalty.'</td>';
                    
                    for($serials = 0; $serials< $count; $serials++)
                    {
                        $currSerial = $newSerial->serialNo($serials+1);
                        if(!array_key_exists($currSerial, $temp->ac))
                            $temp->ac[$currSerial] = 0;
                        if(!array_key_exists($currSerial, $temp->wrongAttempts))
                            $temp->wrongAttempts[$currSerial] = 0;
                        
                        if($temp->ac[$currSerial] ==1)
                        {
                            $show = $temp->timeOfAc[$currSerial] .'('.($temp->wrongAttempts[$currSerial]*-1).')';
                            echo '<td>'.$show.'</td>';
                        }
                        else
                        {
                            
                             $show = '('.($temp->wrongAttempts[$currSerial]*-1).')';
                             echo '<td>'.$show.'</td>';
                            
                        }
 
                    }
                            
                            
                    echo '</tr>';
                    $rank++;
                }   
           
                  
                    echo '   </tbody>
            </table>';
    
    }
    else
    {
        echo "Wrong contest id!";
    }
?>
           
        </div>
    </div>
</div>
   
<footer class="w3-container w3-padding-64 w3-center w3-opacity w3-light-grey w3-xlarge">
 <p class="w3-medium">Powered by <a href="https://csedu.du.ac.bd" target="_blank">CSEDU</a></p>
</footer>
               
 </body>
</html>

<?php
error_reporting(E_ERROR | E_PARSE);
global $con;
$con= mysqli_connect("localhost","cseduoj","cseduoj","cseduoj");
// Check connection
if (mysqli_connect_errno())
  {
     echo "Failed to connect to MySQL: " . mysqli_connect_error();
  }
  
   $qry = "Create Table If Not Exists users (".
                "name VARCHAR( 128 ) NOT NULL ,".
                "id VARCHAR( 128 ) NOT NULL ,".
                "email VARCHAR( 128 ) NOT NULL ,".
                "password VARCHAR( 128 ) NOT NULL ,".
                "verified CHAR(1) NOT NULL,".
                "PRIMARY KEY (id)".
                ")";
                
        if(!mysqli_query($con, $qry))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
        }
        
        $qry = "CREATE TABLE If Not Exists contests(".
                "contestTitle VARCHAR( 128 ) NOT NULL ,".
                "contestId INT NOT NULL,".
                "contestStartDate VARCHAR(10) NOT NULL,".
                "contestStartTime VARCHAR(10) NOT NULL,".
                "contestDuration INT( 240 ) NOT NULL ,".
                "contestEndDate VARCHAR(10) NOT NULL,".
                "contestEndTime VARCHAR(8) NOT NULL,".
                "contestDescription VARCHAR( 128 ) NULL ,". 
                "contestAnnouncements VARCHAR( 128 ) NULL ,". 
                "contestStatus INT NOT NULL DEFAULT '0',".
                "setterId VARCHAR( 128 ) NOT NULL ,".    
                "PRIMARY KEY (contestId),".
                "FOREIGN KEY (setterId) REFERENCES users(id)".
                ")";
          if(!mysqli_query($con, $qry))
            {
                $this->HandleDBError("Error creating the table \nquery was\n $qry");
            }
            
                $qry = "CREATE TABLE If Not Exists problemlist(".
                "problemId VARCHAR( 128 ) NOT NULL ,". 
                "oj VARCHAR( 128 ) NOT NULL ,". 
                "problemName VARCHAR( 128) NOT NULL,".
                "problemIdMod   VARCHAR( 128 ) NOT NULL,".
                "PRIMARY KEY (problemIdMod)".
                ")";
          if(!mysqli_query($con, $qry))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
        }
        
         $qry = "CREATE TABLE If Not Exists contest_problem(".
                "contestId INT NOT NULL ,". 
                "problemIdMod VARCHAR( 128 ) NOT NULL,".
                "serial INT NOT NULL,".
                "solvecount INT NOT NULL DEFAULT '0', ".
                "PRIMARY KEY (contestId, problemIdMod),".
                "FOREIGN KEY (contestId) REFERENCES contests(contestId),".
                "FOREIGN KEY (problemIdMod) REFERENCES problemlist(problemIdMod)".
                ")";
          if(!mysqli_query($con, $qry))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
        }
        
        $qry = "CREATE TABLE If Not Exists contest_submission(".
                "userId VARCHAR( 128 ) NOT NULL,".
                "contestId INT NOT NULL ,". 
                "problemIdMod VARCHAR( 128 ) NOT NULL,".
                "submissionId INT NOT NULL,".
                "serial CHAR(1) NOT NULL,".
                "verdict VARCHAR( 128 ) NOT NULL,".
                "submissionTime VARCHAR(128) NOT NULL,".
                "PRIMARY KEY (submissionId),".
                "FOREIGN KEY (contestId) REFERENCES contests(contestId),".
                "FOREIGN KEY (userId) REFERENCES users(id),".
                "FOREIGN KEY (problemIdMod) REFERENCES problemlist(problemIdMod)".
                ")";
          if(!mysqli_query($con, $qry))
        {
            $this->HandleDBError("Error creating the table \nquery was\n $qry");
        }
?>
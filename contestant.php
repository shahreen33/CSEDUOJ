<?php
error_reporting(E_ERROR | E_PARSE);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of contestant
 *
 * @author ASUS
 */
class attempt{
    
    public $serial, $verdict, $submissionTime;
    function __construct($s, $v, $t) 
    {
        
        $this->serial = $s;
        $this->verdict = $v;
        $this->submissionTime = $t;
    }
    
}
class contestant {
    //put your code here
    public $contestantId, $ACCount=0, $penalty=0;
    
    private $myAttempts=  array();
    public $wrongAttempts = array();
    public $ac = array();
    public $timeOfAc = array();
            
    function addAttempt($newAttempt)
    {
        $serial = $newAttempt->serial;
        if(!array_key_exists($serial, $this->myAttempts))
            $this->myAttempts[$serial] = array();
        $size = count( $this->myAttempts[$serial]);
        //if(!array_key_exists($size, $this->myAttempts[$serial]))
         //   $this->myAttempts[$size] = new attempt();
        $this->myAttempts[$serial][$size] = $newAttempt;    
    }
    function calculate()
    {
        $this->penalty = 0;
        foreach($this->myAttempts as $currKey => $currProblem)
        {
           
            $this->wrongAttempts[$currKey] = 0;
            $this->ac[$currKey] = 0;
            $this->timeOfAc[$currKey] = 0;
            $minTime = 0;
            $isAc = false;
            foreach($currProblem as $currAttempt)
            {
                if($currAttempt->verdict == 'Accepted' || $currAttempt->verdict == 'accepted')
                {
                    $isAc = true;
                                        
                    if($minTime == 0)
                    {
                        $minTime = $currAttempt->submissionTime;
                        
                    }
                    else
                    {
                        $minTIme = min($minTime, $currAttempt->submissionTime);
                    }
                }
                else
                {
                    $this->wrongAttempts[$currKey]++;
                }
            }
            
            if($isAc == true)
            {
                $this->wrongAttempts[$currKey] = 0;
                $this->ac[$currKey] = 1;
                $this->timeOfAc[$currKey] =  (int)($minTime/60);;
                $this->penalty += (int)($minTime/60);
               
                $this->ACCount++;
                foreach($currProblem as $currAttempt)
                {
                    if($currAttempt->submissionTime < $minTime)
                    {
                        $this->penalty+=20;
                        $this->wrongAttempts[$currKey]+=1;
                    }
                    
                }
            }
            
        }
    }
    
}
?>
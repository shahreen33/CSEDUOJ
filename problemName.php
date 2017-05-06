<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include 'problem.php';

$url = $_GET['url'];
$currentProblem = new problem($url);
echo $currentProblem->getProblemName();

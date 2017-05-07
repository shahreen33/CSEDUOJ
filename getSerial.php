<?php
error_reporting(E_ERROR | E_PARSE);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of getSerial
 *
 * @author ASUS
 */
class getSerial {
    //put your code here
    public $serials = array();
    function __construct() {
      $this->serials = ['','A','B', 'C','D', 'E','F', 'G','H', 'I','J', 'K','L', 'M','N', 'O','P', 'Q','R','S', 'T', 'U','V', 'W', 'X','Y', 'Z'];   
    }
     
    
     public function serialNo($num)
     {   
         $ret = $this->serials[$num];
         return $ret;
     }
}

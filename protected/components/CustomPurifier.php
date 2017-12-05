<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CustomePurifier : function for purify the text string for preventing XSS and SQL injection attack
 *
 * @author Suchit
 */
class CustomPurifier extends CApplicationComponent
{
    private $string; // declare the variable 
    public function getPurifyText($string)
    {
        $this->string       =       $string;
        $this->string       =       trim($this->string);
        $p                  =       new CHtmlPurifier();
        $this->string       =       $p->purify($string);
     //   $this->string       =       addslashes($this->string);
        
        
     //   echo $this->string;
       // exit;
        return $this->string;
    }
 
   
}

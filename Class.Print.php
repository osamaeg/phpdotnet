<?php

/*
@desc class printer files
@Author Osama salaam
@Package Service
@Version 0.1
@CopyRight 2010
*/

class printers extends Mysql
{
   public $print_arr    = array();
   public $url          = '';
	
	
	
	
	  public function printer($url,$arr)
   {
       $this->url        = $url;
       $this->print_arr   = $arr;
   }

  public function set_print()
   {
        foreach($this->print_arr as $key => $value)
        {
           $this->print_string .= $key." : ".$value;
        }
       return  $this->print_string;
   }
	
	
	
	
	
	
	
	
}
?>
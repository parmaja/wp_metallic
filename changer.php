<?php

include('color.php');

use phpColors\Color;

class Changer {
	public $ini;
	private $func = array('color'=>'func_color', 'change'=>'func_change', 'gradient'=>'func_gradient');


  function func_color($color, $amount = 0){
  	if ($amount == 0)
    	return $color;
  	else {
	    $co = new Color($color);
      if ($amount > 0)
	      return '#'.$co->lighten($amount);
      else
	      return '#'.$co->darken(abs($amount));
    }
  }

  public function call($name, $arg) {
	  if (array_key_exists($name, $this->func)) {
		  $real_func = $this->func[$name];
      if(is_callable(array($this, $real_func)))
      {
    	  if (is_string($arg)) {
	        $arg = explode(',', $arg);
        }
        if (is_array($arg)) {
	        foreach($arg as $value) {
          	$value = trim($value);
        	  if (substr($value,1)=='$') {
            	$value = $this->ini[$value];
            } elseif (substr($value,1)=='#') {
            } elseif (is_integer($value)) {
            } else {
            }
          }
		      return call_user_func_array(array($this, $real_func), $arg);
        }
      }
	  }
  }
}

$css_changer = new Changer;

?>
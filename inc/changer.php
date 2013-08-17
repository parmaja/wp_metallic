<?php

include('color.php');

use phpColors\Color;

class Changer {

	public $values;
	private $func = array(
  	'value'=>'func_value',
    'color'=>'func_color',
    'mix'=>'func_mix',
    'gradient'=>'func_gradient'
    );


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

  function func_value($value){
  	return $value;
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
            $fc = strtolower(substr($value, 1));
        	  if ($fc=='$') {
            	$value = $this->values[$value];
            } elseif ($fc=='#') {
            } elseif (is_int($value)) {
            } elseif (is_numeric($value)) {
            } elseif ($fc > 'a' and $fc < 'z') {
            	$value = $this->values[$value];
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
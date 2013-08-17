<?php

include('color.php');

use phpColors\Color;

class Changer {

	public $values = array();

  public $colors = array(
    'white' => '#ffffff',
    'red' => '#ff0000',
    'green' => '#008000',
    'blue' => '#0000ff',
    'maroon' => '#800000',
    'orange' => '#ffA500',
    'yellow' => '#ffff00',
    'olive' => '#808000',
    'purple' => '#800080',
    'fuchsia' => '#ff00ff',
    'lime' => '#00ff00',
    'navy' => '#000080',
    'aqua' => '#00ffff',
    'teal' => '#008080',
    'silver' => '#c0c0c0',
    'gray' => '#808080',
    'black' => '#000000'
  );

	private $functions = array(
  	'value'=>'func_value',
    'color'=>'func_color',
    'mix'=>'func_mix',
    'gradient'=>'func_gradient'
    );

  function __construct($values) {
  	if (is_array($values))
	  	$this->values = $values;
  }

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

  function func_mix($color1, $color2, $amount = 50){
    $co = new Color($color1);
    return '#'.$co->mix(abs($amount));
  }

  public function call($name, $arg) {
	  if (array_key_exists($name, $this->functions)) {
		  $real_func = $this->functions[$name];
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
						  if (array_key_exists($value, $this->values))
	            	$value = $this->values[$value];
            	elseif (array_key_exists($value, $this->colors))
              	$value = $this->colors[$value];
            } else {
            }
          }
		      return call_user_func_array(array($this, $real_func), $arg);
        }
      }
	  }
  }

	function changer_replace($matches) {
		return $this->call($matches[1], $matches[2]);
	}

  public function generate($style) {
  	return preg_replace_callback('/\$(.*)\((.*)\)/i', array($this, 'changer_replace'), $style);
  }
}

$css_changer = new Changer;

?>
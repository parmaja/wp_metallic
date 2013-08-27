<?php
/**
*
* Style Changer
*
* This file is part of the "Metallic Theme" for wordpress
*
* @license   LGPL (http://www.gnu.org/licenses/gpl.html)
* @url			 http://www.github.com/parmaja/wp_metallic
* @author    Zaher Dirkey <zaher at parmaja dot com>
*
* @contributor  Louy Alakkad
*
*/

/**
  Usage:
  use this syntax every every $command(argments)

  Examples:
  color: $set(mycolor, #000);

  color: $get(mycolor); get the color without any change
  color: $color(mycolor); same

  color: $lighten(mycolor, 10); make it lighten +10, rabge 0..100
  color: $color(mycolor, 10); make it lighten +10, rabge 100..0..100

  color: $darken(mycolor, 10); make it darken +10, range 0..100
  color: $color(mycolor, -10); range 100..0..100

  color: $mix(mycolor1, mycolor2); mix 2 colors
  color: $mix(mycolor1, mycolor2, 50); mix 2 colors but put more mycolor2 ranged 100..0..100

  TODO:
    You can use nested command
    color: $mix($lighten(mycolor1, 10), mycolor2, 50);
*/

/*TODO
  bug when
*/

include('color.php');

use phpColors\Color;

//define('REGEX_COMMAND', '/\$([a-z_]*)\((.*)\)/iU');
define('REGEX_COMMAND', '/\$([a-z_]*)\((.*)\)/iU');

function split_arg(&$code, $separator = ',')
{
  $ch = '';
  $next_ch = '';
  $l = strlen($code);
  $i = 0;
  $start = 0;
  $single_quotes = 0;
  $double_quotes = 0;
  $parenthesis = 0;
  $return=array();
  while ($i < $l)
  {
    $ch = $code{$i};
    if ($i + 1 < $l)
      $next_ch = $code{$i+1};
    else
      $next_ch = '';

    if ($ch==='"' and $double_quotes == 0)
      $double_quotes++;
    else if ($ch==='"' and $double_quotes > 0)
      $double_quotes--;
    else if ($double_quotes==0) {
      if ($ch==='\'' and $single_quotes == 0)
        $single_quotes++;
      else if ($ch==='\'' and $single_quotes > 0)
        $single_quotes--;
      else if ($single_quotes == 0) {
        if ($ch==='(')
          $parenthesis++;
        else if ($ch===')')
          $parenthesis--;
        else if ($parenthesis == 0) {
          if ($ch===$separator) {
            $return[] = substr($code, $start, $i - $start);
            $start = $i + 1;
          }
        }
      }
    }
    $i++;
  }
  if ($i>=$start)
    $return[] = substr($code, $start, $i - $start);
  return $return;
}

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
    'get'=>'func_get',
    'set'=>'func_set', //set value to new value and return the same value
    'def'=>'func_def', //like set but without retrun any value, it return empty string
    'color'=>'func_color',
    'lighten'=>'func_lighten',
    'darken'=>'func_darken',
    'mix'=>'func_mix',
    'gradient'=>'func_gradient'
    );

  function __construct($values = array()) {
    if (is_array($values))
      $this->values = $values;
  }

  private function func_color($color, $amount = 0){
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

  private function func_lighten($color, $amount = 0){
    func_color($color, $amount);
  }

  private function func_darken($color, $amount = 0){
    func_color($color, -$amount);
  }

  private function func_get($value){
    return $value; //as it
  }

  private function func_def($name, $value){
    $this->values[$name] = $value;
    return '';
  }

  private function func_set($name, $value){
    $this->values[$name] = $value;
    return $value;
  }

  private function func_mix($color1, $color2, $amount = 0) {
    $co = new Color($color1);
    return '#'.$co->mix($color2, $amount);
  }

  private function check_value($value) {
    $value = trim($value);
    $fc = strtolower(substr($value, 0, 1)); //First Char
    if ($fc=='$') {
      //TODO
      //$value = preg_replace_callback(REGEX_COMMAND, array($this, '_changer_replace'), $value);
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
    return $value;
  }

  public function call($name, $arg) {
//    echo '>>>'.$name.">>>".$arg."\n";
    if (array_key_exists($name, $this->functions)) {
      $real_func = $this->functions[$name];
      if(is_callable(array($this, $real_func)))
      {
        if (is_string($arg)) {
          $values = split_arg($arg);
        } else
          $values = $arg;
        if (is_array($values)) {
          foreach($values as &$value) {
            $value = $this->check_value($value);
          }
          try {
            return call_user_func_array(array($this, $real_func), $values);
          } catch (Exception $e) {
            echo 'Error : '.$name.'('.$arg.') > ',  $e->getMessage(), "\n";
          }
        }
      }
    }
  }

  function _changer_replace($matches) {
    return $this->call($matches[1], $matches[2]);
  }

  private function do_replace($contents) {
    $return = preg_replace_callback('/\n?\r?\$\{(.*)\}/isU', array($this, '_replace_values'), $contents);
    $return = preg_replace_callback(REGEX_COMMAND, array($this, '_changer_replace'), $return);
    return $return;
  }

  public function generate($contents) {
    $this->_comments = array();
    
    $return = preg_replace_callback('/(\/\*.*\*\/)/isU', array($this, '_replace_comments'), $contents);
    $return = $this->do_replace($return);
    return str_replace(array_keys($this->_comments), array_values($this->_comments), $return);
  }
  
  private $_comments = array();

  private function _replace_comments($match) {
    $key = '/*CCTMP'.count($this->_comments).'*/';
    $this->_comments[$key] = $match[1];
    return $key;
  }


  private function _replace_values($match) {
    $ini = $this->parse_string($this->values, $match[1]);
    return '';//Empty, we want to delete it from the css
  }

  function parse_string(&$values, $string) {
    $lines = preg_split("/[\n\r]+/", $string);
    foreach($lines as $l){
      $l = trim($l);
      if (!empty($l)) {
        $fc = strtolower(substr($l, 0, 1)); //First Char
        if ($fv !== ';' and $fv !== '[') {
          $kv = preg_split("/[\:\=]/", trim($l));
          if ((isset($kv[0])) and !empty($kv[0])) {
            $k = trim($kv[0]);//TODO dequote the string
            $v = $this->do_replace(trim($kv[1]));
            $values[$k]=$v;
          }
        }
      }
    }
  }

  public function load_values($filename) {
    $this->parse_string($this->values, file_get_contents($filename));
  }
}

function changer_print_css_file($css_file, $values_file) {
  $css_changer = new changer();
  if (file_exists($values_file))
    $css_changer->load_values($values_file);
  $style = file_get_contents($css_file);
  echo $css_changer->generate($style);
}
?>
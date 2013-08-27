<?php
/**
*
* CSS Style Macro
*
* This file is part of the "Metallic Theme" for wordpress
*
* @license      LGPL (http://www.gnu.org/licenses/gpl.html)
* @url			    http://www.github.com/parmaja/wp_metallic
* @author       Zaher Dirkey <zaher at parmaja dot com>
* @dependency   phpColor https://github.com/mexitek/phpColors
*
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

  Inside the css you can use blocks, besure $< or > alone in a line do not mix it with any text
  Examples:

  Next lines is for assign values only
$<
  border=$mix(canvas_back, base, 80)
  background: $mix(canvas_back, base, 90);
  b=false
>

  Next lines is for condition

$if(b)<
  border=$mix(canvas_back, base, 80)
  background: $mix(canvas_back, base, 90);
>

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
  if (substr($code, 0, 1) === '(')
    $code = substr($code, 1);
  if (substr($code, -1, 1) === ')')
    $code = substr($code, 0, -1);

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

class CssMacro {

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

  /*
    c: Condition
    a: Pass paramters as an array otherwise as arguments
  */
  private $functions = array(
    'get'=>array('func_get',''),
    'set'=>array('func_set',''), //set value to new value and return the same value
    'def'=>array('func_def',''), //like set but without retrun any value, it return empty string
    'color'=>array('func_color',''),
    'lighten'=>array('func_lighten',''),
    'darken'=>array('func_darken',''),
    'mix'=>array('func_mix',''),
    'if'=>array('func_if','a,c'),
    'gradient'=>array('func_gradient','')
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

  private function func_if($args){
    if (count($args) == 3) {
      $b = $args[0] == $args[1];
      if ($b) {
        return $args[2];
      }
    } else { //or 2
    $f = (strtoupper($args[0])==='FALSE') || ($args[0]==='0');
    if (!$f)
      return $args[1];
    }
  }

  private function check_value($value) {
    $value = trim($value);
    $fc = strtolower(substr($value, 0, 1)); //First Char
    if ($fc=='$') {
      //TODO
      //$value = preg_replace_callback(REGEX_COMMAND, array($this, '_macro_replace'), $value);
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
      $func = $this->functions[$name][0];
      $func_opt = explode(',', $this->functions[$name][1]);
      if(is_callable(array($this, $func)))
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
            if (in_array('a', $func_opt))
              return call_user_func(array($this, $func), $values);
            else
              return call_user_func_array(array($this, $func), $values);
          } catch (Exception $e) {
            echo 'Error : '.$name.'('.$arg.') > ',  $e->getMessage(), "\n";
          }
        }
      }
    }
  }

  function _macro_replace($matches) {
    return $this->call($matches[1], $matches[2]);
  }

  private function do_replace($contents) {
    $return = preg_replace_callback('/\n?\r?'.'\$([a-z]*(\(.*\))?)?\<(.*)^\>$'.'/imsU', array($this, '_replace_values'), $contents);
    $return = preg_replace_callback(REGEX_COMMAND, array($this, '_macro_replace'), $return);
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
    $cmd = $match[1];
    $cmd = strstr($cmd, '(', true);
    $arg = $match[2];
    $contents = $match[3];

    if (empty($cmd)) {
      $ini = $this->parse_string($this->values, $contents);
      return '';//Empty, we want to delete it from the css
    } else {
      $args = split_arg($arg);
      $args[] = $contents;
      $ret = $this->call($cmd, $args);
      return $ret;
    }
  }

  function parse_string(&$values, $string) {
    $lines = preg_split("/[\n\r]+/", $string);
    foreach($lines as $l){
      $l = trim($l);
      if (!empty($l)) {
        $fc = strtolower(substr($l, 0, 1)); //First Char
        if ($fc !== ';' and $fc !== '[') {
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

function macro_print_css_file($css_file, $values_file) {
  $css_macro = new CssMacro();
  if (file_exists($values_file))
    $css_macro->load_values($values_file);
  $style = file_get_contents($css_file);
  echo $css_macro->generate($style);
}
?>
<?php
/**
*
* Css Flip
*
* @license   lgpl (http://www.gnu.org/licenses/gpl.html)
* @url			 http://www.github.com/parmaja/cssflip
* @author    zaher dirkey <zaher at parmaja dot com>
*
*/

define('s_text', 0);
define('s_statment', 1);
define('s_selector', 2);
define('s_property', 3);
define('s_comment', 4);
define('s_string', 5);

define('u_case_none', 0);
define('u_case_upper', 1);
define('u_case_lower', 2);

//default values
$use_case= u_case_none;
$use_multiline= 0;
$use_last_line_semicolon = false;
$use_eol = "\n";
$use_tabchar = '    ';//or "\t"
$use_tab_end_blocks = '';//or '    ' or "\t"
$use_noflip = false; //false mean just format the files only no flip


function use_case($text) {
  global $use_case;
  if ($use_case==u_case_upper)
    return strtoupper($text);
  elseif ($use_case==u_case_lower)
    return strtolower($text);
  else
    return $text;
}

function str_explode($c, $s)
{
  $p = strpos($s, $c);
  $a = array();
  if ($p!==false)
  {
    $a[] = substr($s, 0, $p);
    $a[] = substr($s, $p+1);
  }
  else
  {
    $a[] = $s;
    $a[] = '';
  }
  return $a;
}

class CssParser {
  var $blocks = array();
  var $block;
  var $comment = '';
  var $text = '';
  var $properties = array();
  var $output;
  var $left_count = 0;
  var $right_count = 0;

  function __construct() {
    $this->block = s_text;
  }

  function write($out)
  {
    if (isset($this->output))
      fwrite($this->output, $out);
    else
      echo $out;
  }

  function open() //virtual
  {
  }

  function close() //virtual
  {
  }

  function flush_out()
  {
    $this->write($this->text);
    $this->text = '';
  }

  function flush_properties()
  {
    global $use_multiline, $use_tabchar, $use_eol, $use_last_line_semicolon, $use_tab_end_blocks; //todo make it member of the class

    $prop_count = count($this->properties);
    if (($prop_count <= $use_multiline))
    {
      $pref = "";
      $suff = "";
    }
    else
    {
      $pref = $use_tabchar;
      $suff = $use_eol;
      $this->write($suff);
    }

    $c = 1;
    foreach ($this->properties as $v)
    {
      if (($c < $prop_count) or ($use_last_line_semicolon===true))
        $this->write($pref.$v.';'.$suff);
      else
        $this->write($pref.$v.$suff);
      $c++;
    }
    $this->write($use_tab_end_blocks.'}');
    $this->properties = array();
  }

  function add_value($name, $value) //virtual
  {
    return use_case($name).': '.use_case($value);
  }

  function add_property()
  {
    global $use_eol;
    $this->text = trim($this->text);
    if (!empty($this->text))
    {
      $this->text = str_replace($use_eol, '', $this->text);
      list($name, $value)=str_explode(':', $this->text);
      $name=trim($name);
      $value=trim($value);

      $this->properties[] = $this->add_value($name, $value);
    }
    $this->text = '';
  }

  function push_block($state)
  {
    $this->blocks[]= $this->block;
    $this->block = $state;
  }

  function pop_block()
  {
    if (empty($this->blocks))
      $this->block = s_text;
    else
    {
      $this->block = array_pop($this->blocks);
    }
  }
/**
 parse() it is main function, scan and parse the line
*/
  function parse($line) {
    $i = 0;
    while ($i < strlen($line))
    {
      $cur_chr = $line{$i};
      if (($i + 1) < strlen($line))
        $next_char = $line{$i + 1};
      else
        $next_char = '';

      if (($this->block!=s_comment) and ($cur_chr == '/') and ($next_char == '*'))  // close by '*/'
      {
        $i++;
        $this->text .= $cur_chr.$next_char;
        $this->push_block(s_comment);
      }
      else
        switch ($this->block) {
          case s_text:
          {
            if ($cur_chr == '@') // close by ';'
            {
              $this->push_block(s_statment);
              $this->text .= $cur_chr;
            }
            else if ($cur_chr == '{') // close by '}'
            {
              $this->write('{');
              $this->push_block(s_property);
            }
            else
              $this->write($cur_chr);
            break;
          }

          case s_statment:
          {
            $this->text .= $cur_chr;
            if ($cur_chr == ';')
            {
              $this->flush_out();
              $this->pop_block();
            }
            break;
          }

          case s_property:
          {
            if ($cur_chr == '}')
            {
              $this->add_property();
              $this->flush_properties();
//                $this->write('}');
              $this->pop_block();
            }
            elseif ($cur_chr == ';')
            {
              $this->add_property();
            }
            else
              $this->text .= $cur_chr;
            break;
          }

          case s_comment:
          {
            if (($cur_chr == '*') and ($next_char == '/'))
            {
              $i++;
              $this->text .= $cur_chr.$next_char;
              $this->flush_out();
              $this->pop_block();
            }
            else
              $this->text .= $cur_chr;
            break;
          }
        }
      $i++;
    }
  }
}

class CssFlip extends CssParser {

  function add_value($name, $value) {
    return $this->flip_value($name, $value);
  }

  function exchange($value)   // if it has 4 value i exchange the 2 and 4 values
  {
    $a=explode(' ', $value);
    if (count($a) == 4)
    {
      $t=$a[3];
      $a[3]=$a[1];
      $a[1]=$t;
    }
    else
      return $value;

    $r='';
    foreach ($a as $v)
    {
//        $v=use_case($v);
      $r=$r.' '.$v;
    }
    return $r;
  }

  function change_value($value)
  {
    $a=explode(' ', $value);
    $r='';
    foreach ($a as $v)
    {
      $v=strtolower($v);
      if ($v == 'right')
        $v= 'left';
      else if ($v == 'left')
        $v= 'right';

      if (empty($r))
        $r=use_case($v);
      else
        $r=$r.' '.use_case($v);
    }
    return $r;
  }

  function flip_value($name, $value)
  {
    global $use_noflip;
    $new_value = trim($value);
    $value = strtolower($new_value);
    $name = strtolower($name);
    if ($use_noflip === false) {
      if ($name == 'direction')
      {
        if ($value=='ltr')
          $new_value=use_case('rtl');
        else if ($value=='rtl')
          $new_value=use_case('ltr');
      }
      //border
      else if ($name == 'left')
        $name='right';
      else if ($name == 'right')
        $name='left';
      else if ($name == 'border-right')
        $name='border-left';
      else if ($name == 'border-left')
        $name='border-right';
      else if ($name == 'border-left-width')
        $name='border-right-width';
      else if ($name == 'border-right-width')
        $name='border-left-width';
      else if ($name == 'border-left-style')
        $name='border-right-style';
      else if ($name == 'border-right-style')
        $name='border-left-style';
      else if ($name == 'border-left-color')
        $name='border-right-color';
      else if ($name == 'border-right-color')
        $name='border-left-color';
      else if ($name == 'border-style')
        $new_value=$this->exchange($new_value);
      else if ($name == 'border-width')
        $new_value=$this->exchange($new_value);
      else if ($name == 'border-color')
        $new_value=$this->exchange($new_value);
      //margin
      else if ($name == 'margin')
        $new_value=$this->exchange($new_value);
      else if ($name == 'margin-right')
        $name='margin-left';
      else if ($name == 'margin-left')
        $name='margin-right';
      //padding
      else if ($name == 'padding')
        $new_value=$this->exchange($new_value);
      else if ($name == 'padding-right')
        $name='padding-left';
      else if ($name == 'padding-left')
        $name='padding-right';
      //others
      else if ($name == 'background')
        $new_value=$this->change_value($new_value);
      else if ($name == 'background-position')
        $new_value=$this->change_value($new_value);
      else if ($name == 'float')
        $new_value=$this->change_value($new_value);
      else if ($name == 'text-align')
        $new_value=$this->change_value($new_value);
      else if ($name == 'clear')
        $new_value=$this->change_value($new_value);
      else if ($name == 'border-color')
        $new_value=$this->exchange($new_value);
      else {
        if (strpos($name, 'left')!==false)
        {
          echo $name.': '.$value."\n";
          $this->left_count++;
        }
        if (strpos($name, 'right')!==false)
        {
          echo $name.': '.$value."\n";
          $this->right_count++;
        }
        if (strpos($value, 'left')!==false)
        {
          echo $name.': '.$value."\n";
          $this->left_count++;
        }
        if (strpos($value, 'right')!==false)
        {
          echo $name.': '.$value."\n";
          $this->right_count++;
        }
      }
    }
    return use_case($name).': '.$new_value;
  }
}

function css_switch_file($file_in, $file_out = '')
{
  $f = fopen($file_in, 'r');
  if ($f!==false)
  {
    $css = new CssParser;
    if (!empty($file_out))
      $css->output = fopen($file_out, 'w');
    $css->open();
    while (!feof($f))
    {
      $line = fgets($f);
      echo $css->parse($line);
    }
    $css->close();
    fclose($f);
    if (isset($css->output))
      fclose($css->output);
    return array($css->left_count, $css->right_count);
  }
}

?>
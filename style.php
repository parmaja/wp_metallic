<?php
header("Content-type: text/css; charset: UTF-8");
header('Content-type: text/css');
header('Cache-control: must-revalidate');

require('inc/macros.php');
/**
  using get make it more faster, we will call get_theme_mod('color_scheme')
  in the header of theme, no need to use SQL/Classes of wordpress here.
*/
if (isset($_GET['gradients']) and !empty($_GET['gradients']))
  $gradients = $_GET['gradients'];

if (empty($gradients))
  $gradients = '0'; //default;

if (isset($_GET['user_color']) and !empty($_GET['user_color']))
  $user_color = $_GET['user_color'];

if (!empty($user_color)) {
  if (substr($user_color, 0, 1) === '#')
    $user_color = substr($user_color, 1);
}

if (isset($_GET['scheme']) and !empty($_GET['scheme']))
  $scheme = $_GET['scheme'];

if (empty($scheme) and (empty($user_color)))
  $scheme = 'gray'; //default;

$css_macro = new CssMacro();
$css_macro->load_values(dirname(__FILE__).'/default.scheme.ini'); //load default values
$css_macro->load_values(dirname(__FILE__).'/schemes/'.$scheme.'.scheme.ini');
$css_macro->set('gradients', $gradients);
$css_macro->set('scheme', $scheme);
if (empty($scheme) && !empty($user_color))
  $css_macro->set('base', '#'.$user_color);
echo $css_macro->generate(file_get_contents(dirname(__FILE__).'/style.css'));

?>
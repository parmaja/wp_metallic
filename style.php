<?php
header("Content-type: text/css; charset: UTF-8");
header('Content-type: text/css');
header('Cache-control: must-revalidate');

require('inc/macros.php');
/**
  using get make it more faster, we will call get_theme_mod('color_scheme')
  in the header of theme, no need to use SQL/Classes of wordpress here.
*/
if (isset($_GET['scheme']) and !empty($_GET['scheme']))
  $scheme = $_GET['scheme'];

if (empty($scheme))
  $scheme = 'gray'; //default;

if (isset($_GET['gradients']) and !empty($_GET['gradients']))
  $gradients = $_GET['gradients'];

if (empty($gradients))
  $gradients = '0'; //default;


$css_macro = new CssMacro();
$css_macro->load_values(dirname(__FILE__).'/default.scheme.ini'); //load default values
$css_macro->load_values(dirname(__FILE__).'/schemes/'.$scheme.'.scheme.ini');
$css_macro->set('gradients', $gradients);
$css_macro->set('scheme', $scheme);
echo $css_macro->generate(file_get_contents(dirname(__FILE__).'/style.css'));

?>
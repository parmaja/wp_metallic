<?php
header("Content-type: text/css; charset: UTF-8");
header('Content-type: text/css');
//header('Cache-control: must-revalidate');

include('inc/changer.php');
/**
  using get make it more faster, we will call get_theme_mod('color_scheme')
  in the header of theme, no need to use SQL/Classes of wordpress here.
*/
if (isset($_GET['scheme']) and !empty($_GET['scheme']))
  $scheme = $_GET['scheme'];

if (empty($scheme))
  $scheme = 'gray'; //default;

$css_changer = new changer();
$css_changer->load_values(dirname(__FILE__).'/default.scheme.ini'); //load default values
$css_changer->load_values(dirname(__FILE__).'/schemes/'.$scheme.'.scheme.ini');
echo $css_changer->generate(file_get_contents(dirname(__FILE__).'\\style.css'));

?>
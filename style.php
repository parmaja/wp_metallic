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
else
  $scheme = 'gray'; //default;

$css_changer = new changer();
changer_print_css_file(dirname(__FILE__).'/style.css', dirname(__FILE__).'/schemes/'.$scheme.'.scheme.ini');

?>
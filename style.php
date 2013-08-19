<?php
header("Content-type: text/css; charset: UTF-8");
header('Content-type: text/css');
header('Cache-control: must-revalidate');

include('inc/changer.php');

$css_changer = new changer();
$name = 'gray'; //get_theme_mod('color_scheme');
$css_changer->load_values_ini(dirname(__FILE__).'\\'.$name.'.style.ini');
$style = file_get_contents(dirname(__FILE__).'\\style.css');
echo $css_changer->generate($style);

?>
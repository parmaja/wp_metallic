<?php
header("Content-type: text/css; charset: UTF-8");
header('Content-type: text/css');
header('Cache-control: must-revalidate');

require('inc/macros.php');
/**
  using get make it more faster, we will call get_theme_mod('color_scheme')
  in the header of theme, no need to use SQL/Classes of wordpress here.
*/
if (isset($_GET['gradients']) && !empty($_GET['gradients']))
  $gradients = $_GET['gradients'];

if (empty($gradients))
  $gradients = '0'; //default;

if (isset($_GET['is_mobile']) && !empty($_GET['is_mobile']))
  $is_mobile= $_GET['is_mobile'];
else
  $is_mobile= false;

if (isset($_GET['scheme']) && !empty($_GET['scheme']))
  $scheme = $_GET['scheme'];

if (empty($scheme))
  $scheme = 'gray'; //default;

if (isset($_GET['user_color']) && !empty($_GET['user_color']))
  $user_color = $_GET['user_color'];

if (!empty($user_color)) {
  if (substr($user_color, 0, 1) === '#')
    $user_color = substr($user_color, 1);
}

$css_macro = new CssMacro();
$css_macro->load_values(__DIR__.'/default.scheme.ini'); //load default values
if (!empty($scheme))
  $css_macro->load_values(__DIR__.'/schemes/'.$scheme.'.scheme.ini');

$contrast = $css_macro->values['contrast'];
if (isset($_GET['contrast']) && !empty($_GET['contrast']))
  $contrast = $_GET['contrast'];

$css_macro->contrast = $contrast;

$css_macro->set('gradients', $gradients);
$css_macro->set('scheme', $scheme);
$css_macro->set('is_mobile', $is_mobile);

if (isset($_GET['font_size']) && !empty($_GET['font_size']))
  $css_macro->set('font_size', $_GET['font_size']);

/*if (isset($_GET['font_name']) && !empty($_GET['font_name']))
  $css_macro->set('font_name', str_replace("'",'', $_GET['font_name'])); */

if (!empty($user_color))
  $css_macro->set('base', '#'.$user_color);

echo $css_macro->generate(file_get_contents(__DIR__.'/style.css'));
?>
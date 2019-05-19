<?php
header("Content-type: text/css; charset: UTF-8");
header('Content-type: text/css');
header('Cache-control: must-revalidate');

include_once __DIR__ . '/inc/macro.php';

include_once __DIR__ . '../../../../wp-includes/class-wp-error.php';
include_once __DIR__ . '../../../../wp-admin/includes/class-wp-filesystem-base.php';
include_once __DIR__ . '../../../../wp-admin/includes/class-wp-filesystem-direct.php';

$wp_filesystem = new WP_Filesystem_Direct(null);

/**
  using get make it more faster, we will call get_theme_mod('color_style')
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

if (isset($_GET['style']) && !empty($_GET['style']))
  $style = $_GET['style'];
else
  $style = '';

if (isset($_GET['user_color']) && !empty($_GET['user_color']))
  $user_color = $_GET['user_color'];

if (!empty($user_color)) {
  if (substr($user_color, 0, 1) === '#')
    $user_color = substr($user_color, 1);
}

class MyCssMacro extends CssMacro
{
  public function func_import($arg)
  {
    global $import, $wp_filesystem;
    if (!empty($import))
      return $wp_filesystem->get_contents(__DIR__.'/styles/'.$import);
  }

  public function __construct()
  {
    parent::__construct();
    $this->register($this, 'import', 'func_import', '');
  }

  public function load_values($filename) {
      global $wp_filesystem;
    $this->parse_values($wp_filesystem->get_contents($filename));
  }
}

$css_macro = new MyCssMacro();

$css_macro->load_values(__DIR__.'/style.ini'); //load default values
if (!empty($style))
  $css_macro->load_values(__DIR__.'/styles/'.$style.'.ini');

if (array_key_exists('import', $css_macro->values))
  $import = $css_macro->values['import'];
else
  $import = '';

$contrast = $css_macro->values['contrast'];
if (isset($_GET['contrast']) && !empty($_GET['contrast']))
  $contrast = $_GET['contrast'];

$css_macro->contrast = $contrast;

$css_macro->set('gradients', $gradients);
$css_macro->set('style', $style);
$css_macro->set('is_mobile', $is_mobile);

if (isset($_GET['font_size']) && !empty($_GET['font_size']))
  $css_macro->set('font_size', $_GET['font_size']);

/*if (isset($_GET['font_name']) && !empty($_GET['font_name']))
  $css_macro->set('font_name', str_replace("'",'', $_GET['font_name'])); */

if (!empty($user_color))
  $css_macro->set('base', '#'.$user_color);

$file = $wp_filesystem->get_contents(__DIR__.'/css/main.css');
echo $css_macro->generate($file);
?>


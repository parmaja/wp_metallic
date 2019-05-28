<?php
header("Content-type: text/css; charset: UTF-8");
header('Content-type: text/css');
header('Cache-control: must-revalidate');

include_once __DIR__ . '/inc/macro.php';
include_once __DIR__ . '/inc/color.php';

include_once __DIR__ . '../../../../wp-includes/class-wp-error.php';
include_once __DIR__ . '../../../../wp-admin/includes/class-wp-filesystem-base.php';
include_once __DIR__ . '../../../../wp-admin/includes/class-wp-filesystem-direct.php';

use Mexitek\phpColors\Color;

$wp_filesystem = new WP_Filesystem_Direct(null);

/**
  Using GET make it more faster, in the header of theme, no need to use SQL/Classes of wordpress here.
*/

if (isset($_GET['gradients']) && !empty($_GET['gradients']))
  $gradients = $_GET['gradients'];

if (empty($gradients))
  $gradients = '0'; //default;

if (isset($_GET['is_mobile']) && !empty($_GET['is_mobile']))
  $is_mobile= $_GET['is_mobile'];
else
  $is_mobile= false;

if (isset($_GET['header']) && !empty($_GET['header']))
{
  $header_color = $_GET['header'];
  if (substr($header_color, 0, 1) === '#')
    $header_color = substr($header_color, 1);
}

if (isset($_GET['canvas']) && !empty($_GET['canvas']))
{
  $canvas_color = $_GET['canvas'];

  if (substr($canvas_color, 0, 1) === '#')
    $canvas_color = substr($canvas_color, 1);
}

if (isset($_GET['highlight']) && !empty($_GET['highlight']))
{
  $highlight_color = $_GET['highlight'];

  if (substr($highlight_color, 0, 1) === '#')
    $highlight_color = substr($highlight_color, 1);
}

class MyCssMacro extends CssMacro
{

  public function load_values($filename) {
    global $wp_filesystem;
    $this->parse_values($wp_filesystem->get_contents($filename));
  }
}

$css_macro = new MyCssMacro();

$css_macro->load_values(__DIR__.'/style.ini'); //load default values

if (array_key_exists('import', $css_macro->values))
  $import = $css_macro->values['import'];
else
  $import = '';

$css_macro->set('gradients', $gradients);
$css_macro->set('is_mobile', $is_mobile);

if (isset($_GET['font_size']) && !empty($_GET['font_size']))
  $css_macro->set('font_size', $_GET['font_size']);

if (!empty($header_color))
  $css_macro->set('header_back', '#'.$header_color);

if (!empty($canvas_color))
  $css_macro->set('canvas_back', '#'.$canvas_color);
else
  $canvas_color = $css_macro->values['canvas_back'];

$contrast = $css_macro->values['contrast'];

if (isset($_GET['contrast']) && !empty($_GET['contrast']))
  $contrast = $_GET['contrast'];

$co = new Color($canvas_color);
if ($co->isLight())
    $contrast = $contrast;
else
    $contrast = -$contrast;

$css_macro->contrast = $contrast;

if (!empty($highlight_color))
  $css_macro->set('highlight', '#'.$highlight_color);


$file = $wp_filesystem->get_contents(__DIR__.'/css/style.css');
echo $css_macro->generate($file);
?>


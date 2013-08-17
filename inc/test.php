<?php
/*
  this is a test file
*/

error_reporting( E_ALL);
ini_set('display_errors', true);

include('changer.php');

$values = array(
  'background'=>'#eee',
  'foreground'=>'#111'
);

$style = 'body {
	background: $color(white, -1);
  color: $color(#cccccc, -1);
}

div {
  /*  background: $color(bg, +1); */
	background: $color(background, -1);
  mixed-color: $mix(#ccc, #f00, 0);
}
';

echo "<code>";
echo "\n------------------------------------------------\n\n";

$css_changer = new changer($values);
echo $css_changer->generate($style);
echo "</code>";
?>
<?php
/*
  this is a test file
*/

include('changer.php');

$style = 'body {
	background: $color(white, -1);
  color: $color(#cccccc, -1);
}

div {
	background: $color($background, -1);
  color: $mix(#ccc, #f00, -1);
}
';

echo "\n------------------------------------------------\n\n";
echo $css_changer->generate($style);

?>
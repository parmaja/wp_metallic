<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<body>
<pre>
<?php
/*
  this is a test file
*/

error_reporting(E_ALL);
ini_set('display_errors', true);

include('changer.php');

$values = array(
  'background'=>'#eee',
  'foreground'=>'#111'
);

$style = '
body {
  color: $color($color(#ccc, 5), 5);
  background: $set(background, $fff);
  color: $color(#cccccc, 0);
}

/**
  Example:
    background: $color(bg, +1);
*/

div {
  /*  background: $color(bg, +1); */
  background: $color(background, -1);
  background2: $get(background);
  mixed-color1: $mix(#ccc, #f00, 0);
  mixed-color2: $mix(#ccc, $color(background, -1), 0);
}
';

echo "\n------------------------------------------------\n\n";

$css_changer = new changer($values);
echo $css_changer->generate($style);

$s = '10,$mix(dfdf,dsds),40';
//var_dump(split_arg($s));
?>
</pre>
</body>
</html>
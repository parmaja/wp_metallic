<?php

include('changer.php');

function metallic_replace($matches) {
	global $css_changer;
	return $css_changer->call($matches[1], $matches[2]);
}

function metallic_generate_css($name) {
	global $css_changer;
	$style = 'code hinting: roll over $color(#cccccc, -1) your expression to see info on specific elements ';
	$css = preg_replace_callback('/\$(.*)\((.*)\)/i', 'metallic_replace', $style);
  echo $css;
}

metallic_generate_css('');

?>
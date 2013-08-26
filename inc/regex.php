<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<body>

<pre>

<?php

error_reporting(E_ALL);
ini_set('display_errors', true);

        define('REGEX_COMMAND', '/\$([a-z_]*)\((.*)\)/iU');

        $a = array(
          '$foo(val, 10)',
          '$foo($bar(val, 10), 10)',
          '$foo_a(val, -10), $foo_b(val, 30)',
          '$foo_a(val, -10), rgb(10, 10, 10)',
          );

        foreach ($a as $s) {
          preg_match_all(REGEX_COMMAND, $s, $matches);
          echo $s."\n\n";
          var_dump($matches)."\n";
          echo "---------------------\n";
        }
?>
</pre>
</body>
</html>
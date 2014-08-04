<?php
require_once('vendor/autoload.php');

use Calculator\Calculator;

$test_string = '1 + 1 - 4 * 4';

$answer = Calculator::calculate($test_string);

echo '<p>The answer for "'. $test_string .'" is ' . $answer . '</p>';

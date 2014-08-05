<?php
require_once('vendor/autoload.php');

use Calculator\Calculator;

$test_string = '1 +  1 - 4 * 4';
$answer = Calculator::calculate($test_string);
echo '<p>The answer for "'. $test_string .'" is <strong>' . $answer . '</strong></p>';

$test_string = " 4 * \t 5 + \n6 / 7";
$answer = Calculator::calculate($test_string);
echo '<p>The answer for "'. $test_string .'" is <strong>' . $answer . '</strong></p>';

$test_string = '   2   +   7 /   6 + 1   * 4';
$answer = Calculator::calculate($test_string);
echo '<p>The answer for "'. $test_string .'" is <strong>' . $answer . '</strong></p>';

<?php
namespace Calculator;

class Calculator {
    protected static $input = null;
    protected static $response = null;
    private static $operators = array(
        0 => array(
            '*' => 'multiply',
            '/' => 'divide',
            '%' => 'modulus'
        ),
        1 => array(
            '+' => 'add',
            '-' => 'subtract'
        )
    );

    /*
    * Main Calculator class: calculate
    * Parameters:
    * (string) $string
    *
    * Returns:
    * (float) parsed value
    * Throws an exception if missing input
    */
    public function calculate($string = null, $precision = 2)
    {
        if (!is_null($string)) {
            self::setInput($string);
        }

        if (is_null(self::$input)) {
            throw new \RuntimeException('No input to process', 500);
        }

        $value = self::process();
        if (is_int($precision) && $precision >= 0) {
            return round($value, $precision);
        } else {
            return $value;
        }
    }

    /*
    * Public function getInput
    * Parameters: none
    *
    * Returns:
    * (mixed) Current value of $input;
    */
    public function getInput()
    {
        return self::$input;
    }

    /*
    * Public function getResponse
    * Parameters: none
    *
    * Returns:
    * (mixed) Current value of $response
    */
    public function getResponse()
    {
        return self::$response;
    }

    /*
    * Public function calculate
    * Parameters:
    * (string) $string
    *
    * Returns:
    * (bool) true if successfully
    * Otherwise, throws exception
    */
    public function setInput($string)
    {
        if (!$string) {
            throw new \RuntimeException('Invalid string submitted to calculate', 500);
        }

        self::$input = (string)$string;

        return true;
    }

    /*
    * Protected function process
    * No input
    *
    * Returns:
    * Calculated value
    * or throws an exception if parsing error
    *
    * THIS IS A VERY EARLY IMPLEMENTATION!
    * Features still to be solved:
    * - Parenthesis
    * - Exponents
    */
    protected function process()
    {
        $working_input = (string)self::$input;

        if (!$working_input) {
            throw new \RuntimeException('No string to process', 500);
        }

        $working_input = self::cleanInput($working_input);

        // split on whitespace (should be number, operator, number, operator... pattern)
        $elements = explode(' ', $working_input);

        // loop once on operators, for high level actions (*, /, %)
        $elements = self::processOperators($elements, self::$operators[0]);

        // loop second time for lower level actions (+, -)
        $elements = self::processOperators($elements, self::$operators[1]);

        // should end with an array with one element
        if (sizeof($elements) === 1) {
            return self::$response = $elements[0];
        } else {
            throw new \RuntimeException('Error processing input string. Invalid value found.', 500);
        }
    }

    private static function cleanInput($input)
    {
        // load operators that we understand
        $ops = array();
        foreach (self::$operators as $layer) {
            $ops = array_merge($ops, array_keys($layer));
        }
        $ops = implode('', $ops);

        // regularize whitespace, first pad operators, then squeeze multiple spaces and other whitespace
        $regex = '/['.preg_quote($ops, '/').']/';
        $input = preg_replace($regex, " $0 ", $input);
        $input = trim(preg_replace('/\s+/', ' ', $input));

        return $input;
    }

    private static function processOperators(array $elements, array $operators)
    {
        // loop over operators and process as fitting
        $length = sizeof($elements);
        for ($i = 0; $i < $length; $i++) {
            // odd keys contain operators
            if (!($i%2)) {
                continue;
            }

            // not processing lower level functions yet
            if (!array_key_exists($elements[$i], $operators)) {
                continue;
            }

            // convert operator into action
            $operator = $operators[$elements[$i]];

            // perform operation
            $elements[$i-1] = call_user_func(array(self, $operator), $elements[$i-1], $elements[$i+1]);

            // clean up processed operator and secondary value
            unset($elements[$i]);
            unset($elements[$i+1]);

            // squish back down array as needed
            $elements = array_values($elements);
            $length = sizeof($elements);
            $i--;
        }

        return $elements;
    }

    // Method to add two numbers
    private static function add($a, $b)
    {
        return $a + $b;
    }

    // Method to subtract two numbers
    private static function subtract($a, $b)
    {
        return self::add($a, (-$b));
    }

    // Method to add two numbers
    private static function multiply($a, $b)
    {
        return $a * $b;
    }

    // Method to subtract two numbers
    private static function divide($a, $b)
    {
        return self::multiply($a, (1/$b));
    }

    // Method to return the remained on two numbers
    private static function modulus($a, $b)
    {
        return $a % $b;
    }
}

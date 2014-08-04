<?php
namespace Calculator;

class Calculator {
    protected static $input = null;
    protected static $response = null;
    private static $operators = array(
        0 => array(
            '*',
            '/',
            '%'
        ),
        1 => array(
            '+',
            '-'
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
    public function calculate($string = null)
    {
        if (!is_null($string)) {
            self::setInput($string);
        }

        if (is_null(self::$input)) {
            throw new \RuntimeException('No input to process', 500);
        }

        return self::process();
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
    */
    protected function process()
    {
        $value = 0;

        // TODO processing algorithm

        return self::$response = $value;
    }
}

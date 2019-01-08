<?php namespace Briteskies\Britejack;

class Helper
{

    /**
     * Read Command Line
     *
     * this method read user input from command line and return the response
     *
     * @param $prompt
     * @return string
     */
    static function read_cli($prompt)
    {
        while (!isset($input)) {
            echo $prompt;
            $input = strtolower(trim(fgets(STDIN)));
        }
        return $input;
    }

}

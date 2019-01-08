<?php namespace Briteskies\Britejack;

class Card
{
    public $key;
    public $value;
    public $suite;

    /**
     * Card constructor.
     *
     * This method initialize the cards and assign them to properties
     *
     * @param $key
     * @param $value
     * @param $suite
     *
     * @return void
     */
    public function __construct($key, $value, $suite)
    {
        $this->key = $key;
        $this->value = $value;
        $this->suite = $suite;
    }
}
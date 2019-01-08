<?php namespace Briteskies\Britejack;

class Deck
{
    public $cards = [];

    /**
     * Deck constructor.
     *
     * This method initialize the deck with cards
     *
     * @return void
     */
    function __construct()
    {
        $suites = ['Spade', 'Clover', 'Diamond', 'Heart'];
        $numbers = [
            '2' => 2,
            '3' => 3,
            '4' => 4,
            '5' => 5,
            '6' => 6,
            '7' => 7,
            '8' => 8,
            '9' => 9,
            '10' => 10,
            'A' => 11,
            'J' => 11,
            'Q' => 12,
            'K' => 13
        ];

        foreach ($suites as $suite) {
            foreach ($numbers as $key => $number) {
                array_push($this->cards, new Card($key , $number, $suite));
            }
        }

        $this->shuffle();


    }

    /**
     *  Get all cards
     *
     * This method return all of the cards exists in deck
     *
     * @return array cards[]
     */
    public function getCards()
    {
        return $this->cards;
    }

    /**
     *  Pop First Card.
     *
     * This method shift an element off the beginning of array
     *
     * @return cards[]
     */
    public function popCards()
    {
        return array_pop($this->cards);
    }

    /**
     *  Shuffle the deck.
     *
     * This method randomizes the order of the elements in all of the cards exists in deck
     *
     * @return void
     */
    private function shuffle()
    {
        shuffle($this->cards);

        $this->burnTop();

    }

    /**
     *  Burn Top.
     *
     * This method remove the first item from all of the cards exists in deck
     *
     * @return void
     */
    private function burnTop()
    {
        array_shift($this->cards);
    }

}

<?php namespace Briteskies\Britejack;

use \Briteskies\Britejack\Deck;
use \Briteskies\Britejack\Dealer;
use Briteskies\Britejack\Game;
use Briteskies\Britejack\Player;

abstract class Gamer
{

    /**
     * Sum Cards.
     *
     * This method calculate sum of given array of cards
     *
     * @param $cards
     * @return int
     */
    public function calc_points($cards)
    {
        foreach ($cards as $key_cards => $card) {
            $card_value[] = ($card->value);
        }

        return array_sum($card_value);
    }

    /**
     * Check Sum of Cards.
     *
     * This method compare sum of given array with Game::MAX_ALLOWED_POINT
     *
     * @param $sum
     * @return bool
     */
    public function check_sum($sum)
    {
        return ($sum >= Game::MAX_ALLOWED_POINT) ? false : true;
    }

    /**
     * Check Ace and sum points.
     *
     * This method check Ace rule and return output string
     *
     * @param $gamer_value Dealer|Player
     * @return array
     */
    public function scoreSum($gamer_value)
    {
        $response_string = '';
        $sum = 0;
        foreach ($gamer_value->currentCards as $value) {
            if ($value->key == "A" && ($sum + $value->value > 21)) {
                $value->value = 1;
            }
            $response_string .= $value->suite . '#' . $value->key . '(' . $value->value . ") , ";
            $sum += $value->value;
        }
        return [$sum, $response_string];

    }

    /**
     * Press Stand .
     *
     * This method run when Player|Dealer fire stand
     *
     * @return bool
     */
    public function stand()
    {
        echo "\n wait for other players Or Dealer! \n";
        return false;
    }


    /**
     * Press Hit.
     *
     * This abstract method implemented in both extended classes (Dealer|Player)
     *
     * @param Deck $deck
     * @param $kind Dealer|Player
     * @return mixed
     */
    abstract public function hit(Deck $deck, $kind);


}
<?php namespace Briteskies\Britejack;

use \Briteskies\Britejack\Gamer;
use \Briteskies\Britejack\Deck;

class Dealer extends Gamer
{

    public $status;
    private $deck;

    const MAX_ALLOWED_POINT_HIT = 17;

    public $currentCards = [];

    /**
     * Dealer Hit
     *
     * this method pop one card from deck and push it to the dealer hand
     *
     * @param \Briteskies\Britejack\Deck $deck
     * @param Dealer $dealer
     * @return bool
     */
    public function hit(Deck $deck, $dealer)
    {
        $this->deck = $deck;
        if (count($this->deck->cards) > 0) {
            $dealer->currentCards[] = $this->deck->popCards();
            return true;
        } else {
            echo("\n Deck is Empty!!!\n");
            return false;
        }
    }

    /**
     * Dealer Logic for choosing Hit Or Stand
     *
     * this method pop one card from deck and push it to the dealer hand
     *
     * @param \Briteskies\Britejack\Deck $deck
     * @param Dealer $dealer
     * @return bool
     */
    public function hitOrStand(Deck $deck, Dealer $dealer)
    {
        if (count($deck->cards) > 0) {

            list($dealer_sum, $dealer_string) = $this->scoreSum($dealer);
            if ($dealer_sum <= Game::MAX_ALLOWED_POINT) {
                if ($dealer_sum >= SELF::MAX_ALLOWED_POINT_HIT) {
                    return false;
                } else {
                    if ($this->hit($deck, $dealer)) {
                        $dealer_sum = $this->calc_points($this->currentCards);
                        $result = $this->check_sum($dealer_sum);
                    } else {
                        $result = false;
                    }

                    if (!$result) {
                        echo $dealer_string;
                    }
                    return $result;
                }
            } else {
                echo "\n Dealer point is $dealer_sum BUST! $dealer_string \n";
                return false;
            }

        } else {
            echo("\n Deck is Empty!!!\n");
            return false;

        }

    }
}


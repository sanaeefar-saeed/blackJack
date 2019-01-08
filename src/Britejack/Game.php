<?php namespace Briteskies\Britejack;

use Briteskies\Britejack\Helper;
use Briteskies\Britejack\Dealer;
use Briteskies\Britejack\Deck;
use Briteskies\Britejack\Gamer;
use Briteskies\Britejack\Card;


class Game
{
    private $playerCount = 1;
    private $player = [];
    private $dealer;
    private $deck;
    private $dealerString = '';
    private $dealerFlag = false;
    private $playerFlag = false;

    const INIT_CARDS_COUNT = 2;
    const MAX_ALLOWED_POINT = 21;


    /**
     * Game constructor.
     *
     * This method initialize the game
     *
     * @param \Briteskies\Britejack\Deck $deck
     * @param \Briteskies\Britejack\Dealer $dealer
     * @return void
     */
    public function __construct(Deck $deck, Dealer $dealer)
    {
        $this->dealer = $dealer;
        $this->deck = $deck;
    }

    /**
     * Run Game
     *
     * This method run the game
     *
     * @return string
     */
    public function run()
    {

        /** how many player will join to the game?*/
        $this->playerCount = Helper::read_cli('How many player want to join ? ');

        /**
         * for all Players && Dealer do 2 time for assigning card
         * in below order :
         * (player#1....player#n),dealer,(player#1....player#n),dealer
         */

        for ($initCardCounter = 0; $initCardCounter < SELF::INIT_CARDS_COUNT; $initCardCounter++) {
            for ($playerCounter = 0; $playerCounter < $this->playerCount; $playerCounter++) {
                /** in first loop create new object for all player */
                if ($initCardCounter == 0) {
                    $this->player[$playerCounter] = new Player;
                }
                $this->player[$playerCounter]->currentCards[] = $this->deck->popCards();
            }

            /** for dealer add one card */
            $dealerValue[] = $this->dealer->currentCards[] = $this->deck->popCards();

            /** in first loop hide the value of the dealer card for players */
            if ($initCardCounter == 0) {
                $this->dealerString = " ? - ";
            } elseif ($initCardCounter == 1) {
                $this->dealerString .= $dealerValue[$initCardCounter]->suite . ' ' . $dealerValue[$initCardCounter]->value;
            }

        }


        /** for all player read from cli */
        foreach ($this->player as $playerKey => $playerValue) {
            do {
                /** if game need more card and deck is empty add new deck */
                if (count($this->deck->cards) == 0) {
                    $this->deck = new Deck;
                }

                /** ask stand OR hit from players til win|bust|stand */
                $this->playerFlag = $this->player[$playerKey]->hitOrStand($this->deck, $this->dealer, $playerKey,
                    $playerValue, $this->dealerString);
                if (!$this->playerFlag) {
                    break;
                }
            } while ($this->playerFlag);
        }

        /** ask stand OR hit from dealer til win|bust|stand */
        do {
            $this->dealerFlag = $this->dealer->hitOrStand($this->deck, $this->dealer);
            if (!$this->dealerFlag) {
                break;
            }
        } while ($this->dealerFlag);


        list($dealerSum, $this->dealerString) = $this->dealer->scoreSum($this->dealer);
        foreach ($this->player as $playerKey => $playerValue) {

            /** find winners */
            echo $this->winner($playerKey);
        }
    }


    /**
     * Run Game
     *
     * This method run the game
     *
     * @param $playerKey
     * @return string
     */
    public function winner($playerKey)
    {

        list($playerSum, $playerString) = $this->player[$playerKey]->scoreSum($this->player[$playerKey]);

        list($dealerSum) = $this->dealer->scoreSum($this->dealer);

        if ($playerSum <= SELF::MAX_ALLOWED_POINT) {
            if ($dealerSum <= SELF::MAX_ALLOWED_POINT) {
                if ($playerSum > $dealerSum) {
                    $result = 'WIN';
                } elseif ($playerSum == $dealerSum) {
                    $result = 'PUSH';
                } else {
                    $result = 'LOSE';
                }
            } else {
                $result = 'WIN';
            }
        } else {
            $result = 'LOSE';
        }

        return "
        \n============================================================================
        \n  Dealer : $this->dealerString
        \n  Player#" . $playerKey . " : $playerString
        \n  \033[32m Player#" . $playerKey . " has " . $playerSum . " ,  Dealer has " . $dealerSum . " \033[31m => You " . $result . " \033[0m
        \n============================================================================
        \n";

    }

}


<?php
/**
 * vendor/autoload.php not found?
 * Run `composer dumpautoload` in this file's directory
 *
 * Don't have composer?  https://GetComposer.org/
 */
require_once 'vendor/autoload.php';

$deck = new Briteskies\Britejack\Deck;
$dealer = new Briteskies\Britejack\Dealer;

$game = new Briteskies\Britejack\Game($deck, $dealer);
$game->run();

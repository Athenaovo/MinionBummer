<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
class DeckTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
		$game = new \Bummer\Game();
		$deckCards = $game->getDeckCards();

		$this->assertEquals(45, count($deckCards));
	}
}

/// @endcond

<?php
namespace Bummer;
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */


class GameTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
	    $game = new Game();
        $names = ["First", "Second", "Third", "Fourth"];
        $game->addPlayers($names);
        $current = $game->getCurrent();
		$players = $game->getPlayers();

        $this->assertInstanceOf('Bummer\Game', $game);

		$this->assertEquals("First", $current->getName());
        $this->assertEquals("yellow", $current->getColor());

        $this->assertEquals("First", $players[0]->getName());
        $this->assertEquals("yellow", $players[0]->getColor());

        $this->assertEquals("Second", $players[1]->getName());
        $this->assertEquals("red", $players[1]->getColor());

        $this->assertEquals("Third", $players[2]->getName());
        $this->assertEquals("green", $players[2]->getColor());

        $this->assertEquals("Fourth", $players[3]->getName());
        $this->assertEquals("blue", $players[3]->getColor());

        $this->assertNotEquals(null, $game->getDeck());
    }

    public function test_hasMinion() {
        $game = new Game();
        $names = ["First", "Second", "Third", "Fourth"];
        $game->addPlayers($names);

    $this->assertTrue($game->hasMinion(['c' => 13, 'r' => 3]));

    $this->assertFalse($game->hasMinion(['c' => 0, 'r' => 0]));
    }
public function test_getMinionFromCell() {
    $game = new Game();
    $names = ["First", "Second", "Third", "Fourth"];
    $game->addPlayers($names);

    $minion = $game->getMinionFromCell(['c' => 13, 'r' => 3]);
    $minion_not = $game->getMinionFromCell(['c' => 0, 'r' => 0]);

    $this->assertEquals($minion->getColor(), "yellow");
    $this->assertEquals($minion_not, null);

    }






}

/// @endcond

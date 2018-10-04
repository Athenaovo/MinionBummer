<?php
namespace Bummer;
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
class WelcomeControllerTest extends \PHPUnit_Framework_TestCase
{

    public function test_construct() {
        $game = new Game();
        $welcome = new Welcome();

        $controller = new WelcomeController($game,$welcome, array('player1' => "Haylee", 'player2' => "Athena", 'player3' => "Gus", 'player4' => "Rachel", ));

        $current = $game->getCurrent();
        $players = $game->getPlayers();

        $this->assertNotNull($players);
        $this->assertInstanceOf('Bummer\WelcomeController', $controller);
        $this->assertEquals($current->getName(), "Haylee");

        $this->assertEquals("Haylee", $players[0]->getName());
        $this->assertEquals("yellow", $players[0]->getColor());

        $this->assertEquals("Athena", $players[1]->getName());
        $this->assertEquals("red", $players[1]->getColor());

        $this->assertEquals("Gus", $players[2]->getName());
        $this->assertEquals("green", $players[2]->getColor());

        $this->assertEquals("Rachel", $players[3]->getName());
        $this->assertEquals("blue", $players[3]->getColor());

        $this->assertEquals(3, count($players[0]->getMinions()));
        $this->assertEquals(3, count($players[1]->getMinions()));
        $this->assertEquals(3, count($players[2]->getMinions()));
        $this->assertEquals(3, count($players[3]->getMinions()));
        $this->assertNotNull($players[0]->getMinions()[0]);
    }
}

/// @endcond

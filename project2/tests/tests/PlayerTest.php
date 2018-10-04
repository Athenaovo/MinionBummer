<?php
namespace Bummer;
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template
 * @cond
 * Unit tests for the class
 */
class PlayerTest extends \PHPUnit_Framework_TestCase
{
    public function test_construct(){
        $player = new Player("yellow", "first");
        $this->assertEquals("yellow", $player->getColor());
        $this->assertEquals("first", $player->getName());
        $this->assertEquals(false, $player->checkWin());
        $this->assertEquals(3, $player->getNumMinions()); //check if 3 minions created
    }

    public function test_minions_start_positions(){
	    $player = new Player();
//	    $this->assertEquals(true, $player->getMinion1()->getAtStart());
//        $this->assertEquals(true, $player->getMinion2()->getAtStart());
//        $this->assertEquals(true, $player->getMinion3()->getAtStart());
//        $this->assertEquals(true, $player->getMinion1()->isSafe());
//        $this->assertEquals(true, $player->getMinion2()->isSafe());
//        $this->assertEquals(true, $player->getMinion3()->isSafe());
//        $this->assertEquals(false, $player->getMinion1()->getAtHome());
//        $this->assertEquals(false, $player->getMinion3()->getAtHome());
//        $this->assertEquals(false, $player->getMinion2()->getAtHome());
        //check if all minions are at correct start positions
	    $this->assertEquals(['c' => 13, 'r' => 3], $player->getMinion1()->getCell());
        $this->assertEquals(['c' => 13, 'r' => 4], $player->getMinion2()->getCell());
        $this->assertEquals(['c' => 13, 'r' => 5], $player->getMinion3()->getCell());
    }
}

/// @endcond

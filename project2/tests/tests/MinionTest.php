<?php
require __DIR__ . "/../../vendor/autoload.php";
/** @file
 * Empty unit testing template
 * @cond 
 * Unit tests for the class
 */
class MinionTest extends \PHPUnit_Framework_TestCase
{
	public function test_construct() {
		$player = new \Bummer\Player("yellow", "first");
		$minions = $player->getMinions();
        $player2 = new \Bummer\Player("red", "second");
        $minions2 = $player2->getMinions();

        /* @var $minion \Bummer\Minion */
		foreach ($minions as $minion) {
		    $this->assertEquals("yellow", $minion->getColor());
		    $this->assertEquals("first", $minion->getPlayer()->getName());
        }
        $cell = $minions[0]->getCell();


        $this->assertEquals(13, $cell['c']);
        $this->assertEquals(3, $cell['r']);

        $cell2 = $minions2[0]->getCell();


        $this->assertEquals(2, $cell2['c']);
        $this->assertEquals(12, $cell2['r']);
	}

	public function test_move() {
    $game = new \Bummer\Game();
    $names = ["First", "Second", "Third", "Fourth"];
    $game->addPlayers($names);

    $minions = $game->getPlayers()[0]->getMinions();
    $minions2 = $game->getPlayers()[1]->getMinions();

    $card1 = new \Bummer\Card(1);
    $card8 = new \Bummer\Card(8);
    $card2 = new \Bummer\Card(2);

    $minions[0]->move($card8, 0);

    $this->assertEquals(0, $minions[0]->getPosition());

    $minions[0]->move($card1, 0);
    $minions2[0]->move($card1, 0);

    $game->bumpMinions($minions[0]);

    // yellow got moved, and red didn't bump it back
    $this->assertEquals(2, $minions[0]->getPosition());
    $this->assertEquals(2, $minions2[0]->getPosition());

    $minions[0]->move($card8, 0);

    $this->assertEquals(10, $minions[0]->getPosition());

    $minions[1]->move($card2, 0);
    $minions[1]->move($card8, 0);
    $this->assertEquals(10, $minions[1]->getPosition());

    $this->assertTrue($minions[0]->isCellEqual($minions[1]));
    $this->assertFalse($minions[0]->isCellEqual($minions[2]));

    $this->assertFalse($minions[0]->isEqual($minions[1]));
    $this->assertTrue($minions[0]->isEqual($minions[0]));
    $minions[2]->move($card2, 0);

    $game->bumpMinions($minions[1]);
    // should have been bumped to start
    $this->assertEquals(0, $minions[0]->getPosition());

    // don't bump this one though
    $this->assertNotEquals(0, $minions[2]->getPosition());





}
    public function test_slide() {
        $game = new \Bummer\Game();
        $names = ["First", "Second", "Third", "Fourth"];
        $game->addPlayers($names);

        $minions = $game->getPlayers()[0]->getMinions();

        $card1 = new \Bummer\Card(1);
        $card3 = new \Bummer\Card(3);
        $card5 = new \Bummer\Card(5);

        $minions[0]->move($card1, 0);
        $minions[0]->move($card1, 0);
        $minions[0]->move($card1, 0);
        $minions[0]->move($card3, 0);

        $minions[1]->move($card1, 0);
        $minions[1]->move($card1, 0);
        $minions[1]->move($card3, 0);

        $game->bumpMinions($minions[1]);
        $game->checkSlide($minions[1]);

        $this->assertEquals(0, $minions[0]->getPosition());
        $this->assertEquals(10, $minions[1]->getPosition());

    }

    public function test_bummer() {
        $game = new \Bummer\Game();
        $names = ["First", "Second", "Third", "Fourth"];
        $game->addPlayers($names);

        $minions = $game->getPlayers()[0]->getMinions();
        $minions2 = $game->getPlayers()[1]->getMinions();

        $card1 = new \Bummer\Card(1);
        $card8 = new \Bummer\Card(8);

        $minions2[0]->move($card1, 0);
        $minions2[0]->move($card8, 0);

        $this->assertEquals(10, $minions2[0]->getPosition());

        $game->bummerCardMove($minions2[0]);

        $this->assertEquals(40, $minions[0]->getPosition());
        $this->assertEquals(0, $minions2[0]->getPosition());


    }
}

/// @endcond

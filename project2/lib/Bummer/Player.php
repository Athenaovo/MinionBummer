<?php
/**
 * Created by PhpStorm.
 * User: Rachel Beard
 * Date: 2/15/18
 */

/*
 * STILL NEEDED:
 *   Should player actions (pass, draw card, etc.) be handled in this class or in a Game or GameController class?
 */
namespace Bummer;
//require 'Minion.php';
class Player extends User
{
    /*
     * CONSTRUCTOR
     * Expects:
     *      string indicating color of player (red, yellow, green, blue)
     *      string indicating name of player
     */
    public function __construct($c = "yellow", $n = "temp")
    {
        $this->color = $c;
        $this->name = $n;
        $this->userid = $this->getId();

        switch ($this->color) {
            case "yellow":
                $this->index = 0;
                break;
            case "red":
                $this->index = 1;
                break;
            case "green":
                $this->index = 2;
                break;
            case "blue":
                $this->index = 3;
                break;
        }

        for($i = 0; $i < 3; ++$i)
        {
            $minion = new Minion($this);
            $minion->setHomeBase($i);
            $minion->setId($i);
            $this->minions[] = $minion;
            ++$this->minionsStart;
        }

    }

    // return player color: red, yellow, green, blue
    public function getColor(){
        return $this->color;
    }

    // set player color: red, yellow, green, blue
    public function setColor($c){
        if( $c == "yellow" || $c == "red" || $c == "blue" || $c == "green" ) {
            $this->color = $c;
        }
    }

    // return whether or not it is the player's turn
    public function isTurn(){
        return $this->turn;
    }

    // return whether or not the player has won
    public function isWin(){
        return $this->won;
    }

    // tell player to take their turn (set turn to TRUE)
    public function takeTurn(){
        $this->turn = true;
    }

    // player finished turn (set turn to FALSE)
    public function tookTurn(){
        $this->turn = false;
    }

    // return the array of minions
    public function getMinions(){
        return $this->minions;
    }

    // return minion1
    public function getMinion1(){
        return $this->minions[0];
    }

    // return minion2
    public function getMinion2(){
        return $this->minions[1];
    }

    // return minion3
    public function getMinion3(){
        return $this->minions[2];
    }

    public function setMinion($id, $mini){
        $this->minions[$id] = $mini;
    }

    /*
     * Check if the player has won or not.
     * Player has won if all of their minions have made it home.
     */
    public function checkWin(){
        if($this->minionsHome == 3) {
            return true;
        }
        return false;
    }

    /*
     * Minion belonging to this player made it home, now update count
     */
    public function minionMadeItHome(){
        $this->minionsHome = $this->minionsHome + 1;

        if($this->checkWin()){
            $this->won = true;
            // WHAT SHOULD THIS DO IF THE PLAYER WINS? DISPLAY MESSAGE? RESTART?
        }

    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getNumMinions(){
        return sizeof($this->minions);
    }

    /**
     * @return int
     */
    public function getIndex()
    {
        return $this->index;
    }


    public function encode() {

        $arr = array();
        $arr["name"] = $this->name;
        $arr["color"] = $this->color;
        $arr["turn"] = $this->turn;
        $arr["won"] = $this->won;
        $arr["minionsHome"] = $this->minionsHome;
        $arr["minionsStart"] = $this->minionsStart;
        $arr["index"] = $this->index;
        $arr["minions"] = [];
        $arr['userid'] = $this->userid;

        foreach($this->minions as $minion) {
            $arr["minions"][] = $minion->encode();
        }

        return $arr;
    }

    public function decode($arr) {
        $this->name = $arr["name"];
        $this->color = $arr["color"];
        $this->turn = $arr["turn"];
        $this->won = $arr["won"];
        $this->minionsHome = $arr["minionsHome"];
        $this->minionsStart = $arr["minionsStart"];
        $this->index = $arr["index"];
        $this->minions = [];
        $this->userid = $arr['userid'];

        foreach($arr["minions"] as $m_arr) {
            $minion = new Minion($this);
            $minion->decode($m_arr);
            $this->minions[] = $minion;
        }

    }
    /*
     * STRING indicating player's name
     */
    private $name = "";

    /*
     * STRING indicating player color: red, yellow, green, blue
     */
    private $color = "";

    /*
     * BOOLEAN indicating whether or not it's this player's turn
     */
    private $turn = false;

    /*
     * BOOLEAN indicating whether or not the character has won!
     */
    private $won = false;

    /*
     * INT indicating number of minions player has at 'home'
     */
    private $minionsHome = 0;

    /*
     * ARRAY indicating minions belonging to player
     */
    private $minions = array();

    /*
     * INT indicating number of minions player has at 'start'
     */
    private $minionsStart = 0;

    private $index;
    private $userid;


}
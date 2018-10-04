<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 2/15/18
 * Time: 11:29 PM
 */

namespace Bummer;

class Game
{
    const SIZE = 16;

    /**
     * Game constructor.
     */
    public function __construct(){
        // set up deck
        $this->deck = new Deck();

        // get stuff from sql row WILL PROBS CHANGE DEPENDING ON HOW WE STRUCTURE OUR DB

        //  set these when you add to the database not when you create the object


        $json_array = array();

        $this->id = 0;
        $this->playerCount = 0;
        $this->status = 'O';
        $this->state = json_encode($json_array);
        $this->id1 = 0;
        $this->id2 = 0;
        $this->id3 = 0;
        $this->id4 = 0;
        $this->current = new Player();
        $this->winner = 0;
    }

    public function encode() {
        $json_array = array();

        $json_array["current"] = $this->current->encode();
        $json_array['turn'] = $this->turn;
        $json_array['deck'] = $this->deck->encode();  // object
        $json_array['winner'] = $this->winner;
        $json_array["players"] = [];

        foreach($this->players as $player) {
            $json_array["players"][] = $player->encode();
        }
        return $json_array;
    }

    public function decode($arr) {
        $this->current = new Player();
        $this->current->decode($arr["current"]);
        $this->turn = $arr["turn"];
        $this->deck = new Deck();
        $this->deck->decode($arr["deck"]);
        $this->winner = $arr["winner"];
        $this->players = [];
        foreach($arr["players"] as $p_arr) {
            $player = new Player();
            $player->decode($p_arr);
            $this->players[] = $player;
        }
    }

    /**
     * @param int $id2
     */
    public function setId2($id2)
    {
        $this->id2 = $id2;
    }

    /**
     * @param int $id3
     */
    public function setId3($id3)
    {
        $this->id3 = $id3;
    }

    /**
     * @param int $id4
     */
    public function setId4($id4)
    {
        $this->id4 = $id4;
    }

    /**
     * @param string $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getPlayerCount()
    {
        return $this->playerCount;
    }

    /**/
    public function getPlayerFromIndex( $ndx )
    {
        return $this->players[$ndx];
    }

    /**
     * @param mixed $playerCount
     */
    public function setPlayerCount($playerCount)
    {
        $this->playerCount = $playerCount;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getId1()
    {
        return $this->id1;
    }

    /**
     * @return mixed
     */
    public function getId2()
    {
        return $this->id2;
    }

    /**
     * @return mixed
     */
    public function getId3()
    {
        return $this->id3;
    }

    /**
     * @return mixed
     */
    public function getId4()
    {
        return $this->id4;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function getPlayers()
    {
        return $this->players;
    }

    /**
     * @return Player
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @return Deck
     */
    public function getDeck()
    {
        return $this->deck;
    }

    /**
     * @return array
     */
    public function getDeckCards() {
        return $this->deck->getCards();
    }

    /**
     * @param $cell
     * @return bool
     */
    public function hasMinion($cell) {
        foreach ($this->players as $player) {
            /* @var $minion \Bummer\Minion */
            foreach($player->getMinions() as $minion) {
                $minion_cell = $minion->getCell();

                if ($cell['r'] == $minion_cell['r'] and $cell['c'] == $minion_cell['c']) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param $cell
     * @return null
     */
    public function getPlayerMinionFromCell($cell){

        $player = $this->getCurrent();

        $minions = $player->getMinions();
        /* @var $minion \Bummer\Minion */
        foreach ($minions as $minion) {
            $minion_cell = $minion->getCell();
            if ($minion_cell['c'] == $cell['c'] and $minion_cell['r'] == $cell['r']) {
                return $minion;
            }
        }
        return null;
    }

    /**
     * @param $cell
     * @return null
     */
    public function getMinionFromCell($cell) {
        foreach ($this->players as $player) {
            $minions = $player->getMinions();
            /* @var $minion \Bummer\Minion */
            foreach ($minions as $minion) {
                $minion_cell = $minion->getCell();
                if ($minion_cell['c'] == $cell['c'] and $minion_cell['r'] == $cell['r']) {
                    return $minion;
                }
            }
        }
        return null;
    }

    /**
     * @return bool
     */
    public function drawCard() {
        $this->sendMessage("testing");
        $returnVal = false;
        if ($this->canDraw) {
            $this->canDraw = false;
            $returnVal = true;

            // if card is DRAW AGAIN or BACK, don't end turn!
            $currentCardNum = $this->getDeck()->getCardDrawn()->getCardNum();
            if($currentCardNum == 14 or $currentCardNum == 2){
                $returnVal = false;
                if ($currentCardNum == 2) {
                    $this->canDraw = true;
                }
            }

            $this->deck->drawCard();
        }
        return $returnVal;
    }

    /**
     * @param $arr
     */
    public function addPlayers($arr) {
        $i = 0;
        foreach ($arr as $name) {
            $this->players[] = new Player($this->colors[$i], $name);
            $i++;
        }
        $this->current = $this->players[0];
    }

    // get index of current player for array

    /**
     * @return int
     */
    public function getTurn() {
      return $this->turn;
    }

    /**
     *
     */
    public function endTurn() {

        $currentCardNum = $this->getDeck()->getCardDrawn()->getCardNum();

        if($currentCardNum != 2 and $currentCardNum != 14) {

            // last player's turn, go back to 0
            if ($this->getTurn() == sizeof($this->players) - 1) {
                $this->turn = 0;
            } // otherwise, just add one to current index
            else {
                $this->turn = $this->getTurn() + 1;
            }

            $this->current = $this->players[$this->turn];
        }

        //Automatically draw card when passing turns
        $this->drawCard();
        $this->canDraw = true;

    }

    /**
     * @return Player
     *
     */
    public function checkEndGame(){

        foreach ($this->players as $player) {
            $minions = $player->getMinions();
            if ($minions[0]->getPosition() == 65 and
                $minions[1]->getPosition() == 65 and
                $minions[2]->getPosition() == 65) {

                //$this->winner = $player->getId();
                $this->winner = $player->getIndex();
                break;
            }
        }
        return $this->winner;
    }

    public function setWinner($win){
        $this->winner = $win;
    }

    /**
     * @param $minion Minion
     */
    public function bumpMinions($minion) {
        $break = false;
        foreach ($this->players as $player) {
            $minions = $player->getMinions();
            /* @var $m \Bummer\Minion */
            foreach ($minions as $m) {
                if ($minion->isCellEqual($m) and !($minion->isEqual($m))) {
                    $m->setPosition($m->getCellFromPosition(0));
                    $break = true;
                    break;
                }
            }
            if ($break) {
                break;
            }
        }
    }

    /**
     * @param $minion
     */
    public function checkSlide($minion){

        /* @var $minion \Bummer\Minion */
        $len = $minion->getSlideLength();
        for ($i = 0; $i < $len; $i++) {
            $minion->setPosition($minion->getCellFromPosition($minion->getPosition() + 1));
            $this->bumpMinions($minion);
        }
    }

    /**
     * @param $minion
     * @return bool
     */
    public function bummerCardMove($minion) {
        $minions = $this->current->getMinions();

        /* @var $minion \Bummer\Minion */

        /* @var $m \Bummer\Minion */
        foreach ($minions as $m) {
            if (!($minion->isSafe()) and $minion->getColor() != $m->getColor()) {
                if ($m->getPosition() == 0) {
                    $m->setPosition($minion->getCell());
                    $minion->setPosition($minion->getCellFromPosition(0));
                    return true;
                }
            }
        }

        return false;
    }


    // game restarted

    /**
     *
     */
    public function restartGame(){
        $this->players = array();
        $this->current = null;
        $this->turn = 0;
        $this->deck->resetDeck();
        $this->winner = null;
    }

    /**
     * @param $canDraw
     */
    public function setCanDraw($canDraw)
    {
        $this->canDraw = $canDraw;
    }

    public function getWinner(){
        return $this->winner;
    }


    public function sendMessage($message) {
        /*
         * PHP code to cause a push on a remote client.
         */
        /*
        $msg = json_encode(array('key'=>'teamken', 'cmd'=>$message));

        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

        $sock_data = socket_connect($socket, '127.0.0.1', 8078);
        if(!$sock_data) {
            echo "Failed to connect";
        } else {
            socket_write($socket, $msg, strlen($msg));
        }
        socket_close($socket);
        */

    }

    /**
     * @param mixed $id1
     */
    public function setId1($id1)
    {
        $this->id1 = $id1;
    }


    private $colors = ["yellow", "red", "green", "blue"];
    private $players = array();
    /* @var $current \Bummer\Player */
    private $current = null;
    private $turn = 0;
    private $deck = null;
    private $winner;
    private $canDraw = true;

    // things for db
    private $id;
    private $playerCount;
    private $status;
    private $state;
    private $id1;
    private $id2;
    private $id3;
    private $id4;

}

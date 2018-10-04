<?php


// namespace Card;


namespace Bummer;
class Deck {

    public function __construct() {
        $this->resetDeck();
    }

    // moved body of construct so we can reset the deck when a new game is started!
    public function resetDeck(){
        $this->startCard = new Card(14);

        for ($i = 1; $i <= 13; $i++) {
            if ($i == 6 or $i == 9) {
                continue;
            }
            else {
                if ($i == 1) {
                    for ($j = 0; $j < 5; $j++) {
                        $card = new Card($i);
                        $this->cards[] = $card;
                    }
                }
                else {
                    for ($j = 0; $j < 4; $j++) {
                        $card = new Card($i);
                        $this->cards[] = $card;
                    }
                }
            }
        }

        //Shuffle deck
        shuffle($this->cards);


        // card back
        $this->cardDrawn = new Card(14);
    }

    /*
    * @params: ()
    * return: drawn card object
    */
    public function drawCard() {

        if($this->index < sizeof($this->cards) - 1) {
            $this->index++;
        }
        else {
            $this->index = 0;
            shuffle($this->cards);
        }


        $this->cardDrawn = $this->cards[$this->index];

    }

    /**
     * @return mixed
     */
    public function getCardDrawn()
    {
        return $this->cardDrawn;
    }

    /**
     * @return array
     */
    public function getCards()
    {
        return $this->cards;
    }

    public function setCardDrawn(){
        $this->cardDrawn = $this->startCard;
    }

    public function encode() {
        $arr = [];
        $arr["index"] = $this->index;
        $arr["cards"] = [];
        foreach ($this->cards as $card) {
            $arr["cards"][] = $card->encode();
        }
        $arr["cardDrawn"] = $this->cardDrawn->encode();
        $arr["startCard"] = $this->startCard->encode();

        return $arr;
    }

    public function decode($arr) {
        $this->index = $arr["index"];
        $this->cards = [];
        foreach($arr["cards"] as $c_arr) {
            $card = new Card(14);
            $card->decode($c_arr);
            $this->cards[] = $card;
        }
        $this->cardDrawn = new Card(1);
        $this->cardDrawn->decode($arr["cardDrawn"]);

        $this->startCard = new Card(14);
        $this->startCard->decode($arr["startCard"]);
    }


    private $cards = array();

    private $index = 0;

    // Card drawn by player
    private $cardDrawn;
    private $startCard;



}
<?php

namespace Bummer;
class Card {


    public function __construct($cardNum) {
        $this->cardNum = $cardNum;
        switch($this->cardNum) {
            case 1:
                $this->spacesToMove[] = 1;
                break;
            case 2:
                $this->spacesToMove[] = 2;
                break;
            case 3:
                $this->spacesToMove[] = 3;
                break;
            case 4:
                $this->spacesToMove[] = -4;
                break;
            case 5:
                $this->spacesToMove[] = 5;
                break;
            case 7:
                $this->spacesToMove[] = 7;
                break;
            case 8:
                $this->spacesToMove[] = 8;
                break;
            case 10:
                $this->spacesToMove[] = 10;
                $this->spacesToMove[] = -1;
                break;
            case 11:
                $this->spacesToMove[] = 11;
                $this->spacesToMove[] = -2;
                break;
            case 12:
                $this->spacesToMove[] = 12;
                break;
        }

    }

    /**
     * @return int for display card on gamephp
     */
    public function getCardNum()
    {
        return $this->cardNum;
    }

    /**
     * @return array
     */
    public function getSpaces()
    {
        return $this->spacesToMove;
    }

    public function encode() {
        $arr = [];
        $arr["cardNum"] = $this->cardNum;
        $arr["spacesToMove"] = $this->spacesToMove;

        return $arr;
    }

    public function decode($arr) {
        $this->cardNum = $arr["cardNum"];
        $this->spacesToMove = $arr["spacesToMove"];

    }


    private $cardNum=14;
    private $spacesToMove = array();

}

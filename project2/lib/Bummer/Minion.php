<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/2/16
 * Time: 14:31
 */

namespace Bummer;

class Minion
{
    const pass = 0; // choose pass to pass the card when invalid movement

    /**
     * Minion constructor.
     * @param $player Player
     */
    public function __construct($player)
    {
        $this->playerIndex = $player->getIndex();
        $this->color = $player->getColor();
        $this->position = 0;
    }

        // move minion!
        // EXPECTS: card drawn and player's choice which is an int indicating indices (so 0 or 1)

        /**
         * @param Card $card
         * @param int $option
         */
        public function move($card, $option = 0)
        {
            $spacesToMove = $card->getSpaces();
            $successfulMove = false;

            // make sure not a bummer card
            if ($card->getCardNum() != 13) {
                // if the minion is at start, has to be the first option of card 1 or 2 selected to move them
                if ($this->position == 0) {
                    if ($card->getCardNum() == 1 or $card->getCardNum() == 2) {
                        $this->position += 1;
                        $successfulMove = true;
                    }
                }
                // Check to see if minion can get home exactly
                else if ($this->position + $spacesToMove[$option] <= 65) {
                    if (!(($this->position == 1 or $this->position == 2) and $spacesToMove[$option] < 0)) {
                        $this->position += $spacesToMove[$option];
                        $successfulMove = true;
                    }
                }

                if($this->position < 0){
                    $this->position = $this->position + 60;
                }

            }

            return $successfulMove;
        }

        public function getSlideLength() {
            switch ($this->getPosition()) {
                default:
                    return 0;
                case 13:
                case 28:
                case 43:
                case 58:
                    return 3;
                case 6:
                case 21:
                case 36:
                case 51:
                    return 4;
            }
        }



        /**
         * Get the cell on the board for this Minion
         * @returns array Array containing the absolute row and column
         */
        public function getCell()
        {
            $cell = $this->getLocalCell();
            $r = $cell['r'];
            $c = $cell['c'];
            switch ($this->playerIndex) {
                default:    // Yellow
                    return $cell;
                //means have to make players to be 0,1,2,3 to fit the case
                case 1:     // Red
                    return ['c' => Game::SIZE - $c - 1, 'r' => Game::SIZE - $r - 1];
                case 2:     // Green
                    return ['c' => Game::SIZE - $r - 1, 'r' => $c];
                case 3:     // Blue
                    return ['c' => $r, 'r' => Game::SIZE - $c - 1];
            }
        }

        /**
         * Convert the location of the Minion into a row and column.
         * @return array Array containing the row and column for the Minion
         */
        private function getLocalCell()
        {
            if ($this->position == 0) {
                // We are at home!
                return ['c' => 13, 'r' => 3 + $this->homeBase];
            } else if ($this->position <= 12) {
                return ['c' => 15, 'r' => 3 + $this->position];
            } else if ($this->position <= 27) {
                return ['c' => 15 - ($this->position - 12), 'r' => 15];
            } else if ($this->position <= 42) {
                return ['c' => 0, 'r' => 15 - ($this->position - 27)];
            } else if ($this->position <= 57) {
                return ['c' => ($this->position - 42), 'r' => 0];
            } else if ($this->position <= 59) {
                return ['c' => 15, 'r' => ($this->position - 57)];
            } else if ($this->position <= 64) {
                return ['c' => 15 - ($this->position - 59), 'r' => 2];
            } else {    // Home is at 65
                return ['c' => 8, 'r' => 1 + $this->homeBase];
            }
        }

        /**
         * Get the cell on the board for this Minion
         * @param int position
         * @returns array Array containing the absolute row and column
         */
        public function getCellFromPosition($position)
        {
            $cell = $this->getLocalCellFromPosition($position);
            $r = $cell['r'];
            $c = $cell['c'];

            switch ($this->playerIndex) {
                default:    // Yellow
                    return $cell;
                //means have to make players to be 0,1,2,3 to fit the case
                case 1:     // Red
                    return ['c' => Game::SIZE - $c - 1, 'r' => Game::SIZE - $r - 1];
                case 2:     // Green
                    return ['c' => Game::SIZE - $r - 1, 'r' => $c];
                case 3:     // Blue
                    return ['c' => $r, 'r' => Game::SIZE - $c - 1];
            }
        }

        /**
         * Convert the location of the Minion into a row and column.
         * @return array Array containing the row and column for the Minion
         */
        private function getLocalCellFromPosition($position)
        {
            if ($position == 0) {
                // We are at home!
                return ['c' => 13, 'r' => 3 + $this->homeBase];
            } else if ($position <= 12) {
                return ['c' => 15, 'r' => 3 + $position];
            } else if ($position <= 27) {
                return ['c' => 15 - ($position - 12), 'r' => 15];
            } else if ($position <= 42) {
                return ['c' => 0, 'r' => 15 - ($position - 27)];
            } else if ($position <= 57) {
                return ['c' => ($position - 42), 'r' => 0];
            } else if ($position <= 59) {
                return ['c' => 15, 'r' => ($position - 57)];
            } else if ($position <= 64) {
                return ['c' => 15 - ($position - 59), 'r' => 2];
            } else {    // Home is at 65
                return ['c' => 8, 'r' => 1 + $this->homeBase];
            }
        }

        // Update whether the minion is safe

        /**
         *
         */
        public function isSafe()
        {
            if ($this->position >= 60 and $this->position <= 65 or $this->position == 0) {
                return true;
            } else {
                return false;
            }
        }

        // get color of minion

        /**
         * @return string
         */
        public function getColor()
        {
            return $this->color;
        }


        //get invalid true false
        public function getInvalid()
        {
            return $this->invalid;
        }

        /**
         * @param int $homeBase
         */
        public function setHomeBase($homeBase)
        {
            $this->homeBase = $homeBase;
        }

        /**
         * @param array $cell
         */
        public function setPosition($cell)
        {
            $c = $cell['c'];
            $r = $cell['r'];

            switch ($this->playerIndex) {
                default:    // Yellow
                    break;
                //means have to make players to be 0,1,2,3 to fit the case
                case 1:     // Red
                    $cell = ['c' => Game::SIZE - $c - 1, 'r' => Game::SIZE - $r - 1];
                    break;
                case 2:     // Green
                    $cell = ['c' => $r, 'r' => Game::SIZE - $c - 1];
                    break;
                case 3:     // Blue
                    $cell = ['c' => Game::SIZE - $r - 1, 'r' => $c];
                    break;
            }

            $c = $cell['c'];
            $r = $cell['r'];

            if ($c == 13 and $r >= 3 and $r <= 5) {
                $this->position = 0;    // Start
            } else if ($c == 15 and $r > 3 and $r <= 15) {
                $this->position = $r - 3;
            } else if ($r == 15 and $c >= 0 and $c <= 15) {
                $this->position = 27 - $c;
            } else if ($c == 0 and $r >= 0 and $r <= 15) {
                $this->position = 42 - $r;
            } else if ($c >= 0 and $c <= 15 and $r == 0) {
                $this->position = 42 + $c;
            } else if ($c == 15 and $r >= 0 and $r <= 2) {
                $this->position = 57 + $r;
            } else if ($r == 2 and $c >= 10 and $c <= 14) {
                $this->position = 64 - $c + 10;
            } else if ($c == 8 and $r >= 1 and $r <= 3) {
                $this->position = 65;
            }
        }


        /**
         * @return int
         */
        public function getPosition()
        {
            return $this->position;
        }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $minion Minion
     * @return bool
     */
        public function isCellEqual($minion) {
            $first = $minion->getCellFromPosition($minion->getPosition());
            $second = $this->getCellFromPosition($this->position);


            if ($first['c'] == $second['c'] and $first['r'] == $second['r']) {
                return true;
            }
            else {
                return false;
            }
        }

        /**
         * @param $minion Minion
         * @return bool
         */
    public function isEqual($minion) {
        if ($this->id == $minion->getId() and $this->color == $minion->getColor()) {
            return true;
        }
        else
            return false;
    }

    public function setId($id) {
            $this->id = $id;
    }

    public function encode() {
        $arr = array();

        $arr["homeBase"] = $this->homeBase;
        $arr["position"] = $this->position;
        $arr["playerIndex"] = $this->playerIndex;
        $arr["id"] = $this->id;
        $arr["color"] = $this->color;
        $arr["invalid"] = $this->invalid;

        return $arr;
    }

    public function decode($arr){
        $this->homeBase = $arr["homeBase"];
        $this->position = $arr["position"];
        $this->playerIndex = $arr["playerIndex"];
        $this->id = $arr["id"];
        $this->color = $arr["color"];
        $this->invalid = $arr["invalid"];
    }

    public function getPlayerIndex(){
        return $this->playerIndex;
    }

        private $homeBase = 0;
        private $position = 0;
        private $playerIndex;
        private $id = 0;
        private $color;
        private $invalid = false;

    }

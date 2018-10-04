<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 2/18/18
 * Time: 3:25 PM
 */

namespace Bummer;



class GameView extends View
{
    /**
     * Constructor
     * @param Game $bummer The game object
     */
    public function __construct(/*Game $bummer,*/ $id, Site $site) {
        //$this->bummer = $bummer;
        $games = new \Bummer\Games($site);
        $this->bummer = $games->get($id);
        $this->site = $site;

        $json = $this->bummer->getState();
        $this->bummer->decode(json_decode($json, true));

        $this->addLink("instructions.php", "How to Play");
        $this->addLink("post/logout.php", "Log Out");
    }

    public function presentForm() {
        $id = $this->bummer->getId();

        $html = <<< HTML
        <form method="post" action="game-post.php?id=$id">
HTML;
        return $html;
    }

    /**
     * @return string
     */
    public function presentGameGrid() {
        $this->players = $this->bummer->getPlayers();
        $html = "";
        if (count($this->players) > 1) {

            /* @var $player Player */
        foreach($this->players as $player) {
            $this->minionsList[] = $player->getMinions();
        }

        $html = "";
        for ($r = 0; $r < 16; $r++) {
            $html .= <<< HTML
            <div class="row">
            <div class="cell"><input type="submit" name="square" value="0, $r"
HTML;
            /* @var $minion Minion */
            foreach($this->minionsList as $minions) {
                foreach ($minions as $minion) {
                    $cell = $minion->getCell();
                    if (trim($cell['c']) == 0 and trim($cell['r']) == $r) {
                        $color = $minion->getColor();
                        $html .= <<< HTML
                  class="$color"
HTML;
                    }
                }
            }

            $html .= ">";
            for ($c = 1; $c < 16; $c++) {
                $html .= <<< HTML
                </div><div class="cell"><input type="submit" name="square" value="$c, $r"
HTML;

                /* @var $minion Minion */
                foreach($this->minionsList as $minions)
                {
                    foreach ($minions as $minion) {
                        $cell = $minion->getCell();
                        if (trim($cell['c']) == $c and trim($cell['r']) == $r) {
                            $color = $minion->getColor();
                              $html .= <<< HTML
                  class="$color"
HTML;

                          }
                    }
                }
                $html .= ">";
            }
            $html .= '</div></div>';
        }
        }
        return $html;
    }


    /**
     * @return string
     */
    public function presentPlayArea() {
        $html = "";


        //if game ends, display message

        if (count($this->players) > 1) {
            $view = new CardView();
            $deck = $this->bummer->getDeck();
            $cardNum = $deck->getCardDrawn()->getCardNum();
            $class = $view->presentClass($cardNum);

            $html = <<< HTML
          <div class="play">
            <p class="turn">Draw a card!</p>
            <input type="submit" id="card" name="card" value="$cardNum" class="$class">
          </div>

HTML;
            $html .= "<div class='options'>";
            if ($cardNum == 10 or $cardNum == 11) {

                $html .= "<input type='checkbox' name='option' value=1>
                            <label> Backwards? </label>";
            }



        $html .= "</div>";

        }
        return $html;
    }

    /**
     * @return string
     */
    public function displayMenu(){

        $playerName = $this->bummer->getCurrent()->getName();
        $playerColor = $this->bummer->getCurrent()->getColor();
        $winner = $this->bummer->getWinner();

        $html = <<< HTML
            
            <div class="sidebar">
            
HTML;

        // there is a winner! display their name
        if( $winner != 0 ){

            $player = $this->bummer->getPlayerFromIndex($winner);

            $playerName = $player->getName();
            $playerColor = $player->getColor();
            $html .= <<< HTML
                
            <p>
                <i>Game Over!</i>
                <b>$playerName is the winner!</b>
                <div class=$playerColor></div>
                <div class="turnBtn">
                    <input type="submit" value="New Game!" name="restartGame" formmethod="post">
            </div>
            </p>
            
        </div>
            
HTML;
        }

        else {

            $html .= <<< HTML
        
            <p><b>$playerName's Turn! <div class=$playerColor></div></b></p>
            
            <div class="turnBtn">
                    <input type="submit" value="Pass" name="finishTurn" formmethod="post">
            </div>
        </div>

HTML;

        }

        return $html;

    }

    /* @var $bummer Game */
    private $bummer;
    private $players;
    private $site;
    private $minionsList;
}

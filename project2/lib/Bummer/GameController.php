<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 2/18/18
 * Time: 7:04 PM
 */

namespace Bummer;

class GameController
{
    public function __construct(/*Game $game, */$id, $POST, Site $site, array &$session)
    {
        $games = new Games($site);

        $this->game = $games->get($id);
        $json = $this->game->getState();
        $this->game->decode(json_decode($json, true));

        $this->site = $site;

        $user = $session[User::SESSION_NAME];

        if ($this->game->getWinner() == 0 and $this->game->getCurrent()->getName() == $user->getName()) {

            // finish turn -> go to next player!
            if (isset($POST['finishTurn'])) {

                $this->game->endTurn();
                $this->game->getDeck()->setCardDrawn();

                /*$games = new Games($site);

                $json_array = $this->game->encode();

                $this->game->setState(json_encode($json_array));

                $games->update($this->game);*/

            }

            if (isset($POST['square'])) {

                $input = explode(",", strip_tags($POST['square']));

                $cell = ['c' => $input[0], 'r' => $input[1]];

                $choice = 0;

                if (isset ($POST['option'])) {
                    $choice = $POST['option'];
                }

                $successfulMove = false;
                if ($this->game->getDeck()->getCardDrawn()->getCardNum() == 13) {
                    $minion = $this->game->getMinionFromCell($cell);

                    if ($minion != null and $this->game->getCurrent()->getColor() == $minion->getColor()) {
                        $successfulMove = $this->game->bummerCardMove($minion);
                    }
                } else {
                    $minion = $this->game->getPlayerMinionFromCell($cell);

                    if ($minion != null and $this->game->getCurrent()->getColor() == $minion->getColor()) {

                        /* @var $minion \Bummer\Minion */
                        $successfulMove = $minion->move($this->game->getDeck()->getCardDrawn(), $choice);
                    }
                }

                if ($successfulMove and $minion != null) {

                    if ($this->game->getDeck()->getCardDrawn()->getCardNum() != 2) {
                        $this->game->endTurn();
                    } else {
                        $this->game->setCanDraw(true);
                    }
                    $this->game->getDeck()->setCardDrawn();

                    $this->game->bumpMinions($minion);
                    $this->game->checkSlide($minion);

                    $minid = $minion->getId();
                    $playerindex = $minion->getPlayerIndex();

                    $player = $this->game->getPlayerFromIndex($playerindex);
                    $player->setMinion($minid, $minion);

                }

            }

            if (isset($POST['card'])) {
                if ($this->game->drawCard()) {
                    $this->game->endTurn();
                    $this->game->getDeck()->setCardDrawn();
                }

                /*$games = new Games($site);

                $json_array = $this->game->encode();

                $this->game->setState(json_encode($json_array));

                $games->update($this->game);*/

            }

            if(count($_POST) != 0) {

                $winner = $this->game->checkEndGame();

                $this->game->setWinner($winner);

                $json_array = $this->game->encode();

                $this->game->setState(json_encode($json_array));

                $games->update($this->game);
            }

        }

        else{

            if (isset($POST['restartGame'])) {
                $this->game->restartGame();
            }

        }

    }

    private $game;
    private $site;
}

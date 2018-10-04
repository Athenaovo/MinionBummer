<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 2/19/18
 * Time: 2:42 AM
 * */

namespace Bummer;


class WelcomeController
{

    public function __construct( Game $bummer, Welcome $welcome, Site $site, $id, $POST)
    {
        $this->welcome = $welcome;
        $this->validusers = false;
        $this->game = $bummer;
        $this->site = $site;

        /*if(isset($POST['start'])) {
            $this->game->setStatus('C');
            $games = new Games($this->site);
            if($POST['player1'] != "" and $POST['player2'] != "" and $this->checkUnique($POST)) {
                $this->welcome->submitted(true);

                // send player names to game class
                $this->validusers = true;
            }
            else {
                $this->welcome->submitted(false);
            }

            $this->updatePlayers( $POST );
            $games->update($this->game);

        }




        // Restart Game
        $bummer->restartGame();
        //$this->game->restartGame();


    }*/

        if(isset($POST['leave'])) {

        }

        if(isset($POST['start'])) {
            $this->game->setStatus('C');

            // Restart Game
            $bummer->restartGame();
            //$this->game->restartGame();

            if ($POST['player1'] != "" and $POST['player2'] != "" and $this->checkUnique($POST)) {
                $this->welcome->submitted(true);

                // send player names to game class
                $this->validusers = true;
            } else {
                $this->welcome->submitted(false);
            }

            $this->updatePlayers($POST);
        }

    }

    public function checkUnique( $POST ){

        // compare player1 and player2
        if( $POST['player1'] == $POST['player2']){
            return false;
        }

        // if player 3 exists, compare it to player1 and player2
        if( $POST['player3'] != "" and
            ($POST['player3'] == $POST['player1'] or $POST['player3'] == $POST['player2'])){

            return false;
        }

        // if player 4 exists, compare it to player1, player2 and player3
        if( $POST['player4'] != "" and
            ($POST['player4'] == $POST['player3'] or $POST['player4'] == $POST['player2'] or
            $POST['player4'] == $POST['player1'])){

            return false;
        }

        return true;

    }

    /*
     *  * User: hayleequarles
     * Date: 2/19/18
     * Time: 11:04 AM
     */

    public function updatePlayers( $POST )
    {

        $players = array();

        if ($POST['player1'] != "") {
            $players[] = strip_tags($POST['player1']);
        }
        if ($POST['player2'] != "") {
            $players[] = strip_tags($POST['player2']);
        }
        if ($POST['player3'] != "") {
            $players[] = strip_tags($POST['player3']);
        }
        if ($POST['player4'] != "") {
            $players[] = strip_tags($POST['player4']);
        }

        $this->game->addPlayers($players);

        $games = new Games($this->site);
        $thisgame = $games->get($this->game->getId());

        $id1 = $thisgame->getId1();
        $id2 = $thisgame->getId2();
        $id3 = $thisgame->getId3();
        $id4 = $thisgame->getId4();

        $this->game->setId1($id1);
        $this->game->setId2($id2);
        $this->game->setId3($id3);
        $this->game->setId4($id4);
        $this->game->setPlayerCount(count($players));

        $json_array = $this->game->encode();

        $this->game->setState(json_encode($json_array));

        $games->update($this->game);

        $games = new Games($this->site);
        $games->update($this->game);

    }

    public function isValid(){
        return $this->validusers;
    }

private $welcome;
private $validusers;
private $site;
private $game;
}
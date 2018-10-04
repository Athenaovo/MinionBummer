<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 2/19/18
 * Time: 3:00 PM
 */

namespace Bummer;


class Welcome
{

    private $moreThanTwo;
    private $loggedin = False;

    public function __construct(array &$session) {
        $this->moreThanTwo = false;
        $user = null;

        if(isset($session[User::SESSION_NAME])) {
            $user = $session[User::SESSION_NAME];
        }
        if($user != null){
            $loggedin = True;
        }
    }

    public function getLoggedIn(){
        return $this->loggedin;
    }

    public function submitted( $boo ) {
        $this->moreThanTwo = $boo;
    }

    // returns false if there are 0 or 1 players,
    //      otherwise returns true.
    public function enoughPlayers(){
        return $this->moreThanTwo;
    }

}
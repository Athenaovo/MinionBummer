<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 2/19/18
 * Time: 1:41 AM
 */

namespace Bummer;


/**
 * Class WelcomeView
 * @package Bummer
 */
class WelcomeView extends View
{

    private $welcome;

    /**
     * Constructor
     * @param $w Welcome
     */
    public function __construct( Welcome $w ) {

        $this->welcome = $w;

        if (isset($_SESSION[User::SESSION_NAME])) {
            //$users = new Users($site);
            $user = ($_SESSION[User::SESSION_NAME]);
            //$username = $user->getName();
        }

        if($user != null) {
            $this->addLink("post/logout.php", "Logout");
            $this->addLink("lobby.php", "Join Game");
            $this->addLink("instructions.php", "How to Play");
        }
        else {
            $this->addLink("register.php", "Register");
            $this->addLink("index.php", "Login");
            $this->addLink("instructions.php", "How to Play");
        }

    }


}
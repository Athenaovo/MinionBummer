<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 4/8/18
 * Time: 8:30 PM
 */

namespace Bummer;


class StartNewGameController
{

    public function __construct(Site $site, array &$session, array $post) {

        $root = $site->getRoot();
        $games = new Games($site);
        $game = new Game();
        $user = $session[User::SESSION_NAME];
        $game->setId1($user->getId());
        $game->setPlayerCount(1);
        $id = $games->add($game);
        $game->setId($id);

        $this->redirect = "$root/wait.php?id=$id";

    }


    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    private $redirect;	///< Page we will redirect the user to.

}
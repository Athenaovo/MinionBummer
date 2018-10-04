<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 4/10/18
 * Time: 3:34 PM
 */

namespace Bummer;


class LobbyController
{
    public function __construct(Site $site, $session, array $post)
    {
        $this->site = $site;
        $user = $session[User::SESSION_NAME];
        $root = $site->getRoot();
        if (isset($post['new'])) {
            $this->redirect = "$root/startnewgame.php";
        } elseif (isset($post['id'])) {
            $id = strip_tags($post['id']);

            $games = new Games($site);
            $game = $games->get($id);
            $count = $game->getPlayerCount();

            if ($count < 4) {

                $game->setPlayerCount($game->getPlayerCount() + 1);

                if ($count == 1) {
                    $game->setId2($user->getId());
                } else if ($count == 2) {
                    $game->setId3($user->getId());
                } else if ($count == 3) {
                    $game->setId4($user->getId());
                }

                $user->setGameid($game->getId());

                $games->update($game);


                $this->redirect = "$root/wait.php?id=$id";


                //when other players join the room auto refresh
                /*
                 * PHP code to cause a push on a remote client.
                 */
                $msg = json_encode(array('key' => 'teamken_wait', 'cmd' => 'reload'));

                $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

                $sock_data = socket_connect($socket, '127.0.0.1', 8078);
                if (!$sock_data) {
                    echo "Failed to connect";
                } else {
                    socket_write($socket, $msg, strlen($msg));
                }
                socket_close($socket);
            } else {


                $this->redirect = "$root/lobby.php";
            }

        } else {
            $this->redirect = "$root/lobby.php";
        }


    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    private $redirect;	///< Page we will redirect the user to.

    private $site;
}
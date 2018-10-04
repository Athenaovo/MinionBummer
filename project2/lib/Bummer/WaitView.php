<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 4/5/18
 * Time: 11:16 AM
 */

namespace Bummer;

class WaitView extends View
{
    public function __construct(Site $site)
    {
        $this->site = $site;
        if (isset($_GET['id'])) {
            $this->id = strip_tags($_GET['id']);
        }

        $this->addLink("post/logout.php", "Logout");
        $this->addLink("lobby.php", "Join Game");
        $this->addLink("instructions.php", "How to Play");

    }

    public function present()
    {

        $games = new Games($this->site);
        $game = $games->get($this->id);
        $users = new Users($this->site);

        $id1 = $game->getId1();
        $p1 = $users->get($id1);
        if ($p1 != null) {
            $p1name = $p1->getName();
        } else {
            $p1name = "";
        }

        $id2 = $game->getId2();
        $p2 = $users->get($id2);
        $p2name = null;
        if ($p2 != null) {

            $p2name = $p2->getName();
        }

        $id3 = $game->getId3();
        $p3 = $users->get($id3);
        $p3name = null;
        if ($p3 != null) {

            $p3name = $p3->getName();
        }


        $id4 = $game->getId4();
        $p4 = $users->get($id4);
        $p4name = null;
        if ($p4 != null) {

            $p4name = $p4->getName();
        }

        $html = <<<HTML

        
<div class="welcomeLogin">

        <p>Waiting on players to join the game! </p>

        <form method="post" action="welcome-post.php?id=$this->id">

            <p>Player 1: $p1name</p>
            <p>Player 2: $p2name</p>
            <p>Player 3: $p3name</p>
            <p>Player 4: $p4name</p>

            <input type="hidden" name="player1" value="$p1name">
            <input type="hidden" name="player2" value="$p2name">
            <input type="hidden" name="player3" value="$p3name">
            <input type="hidden" name="player4" value="$p4name">

            <input type="submit" name = "start" value="Start Game!">
        </form>

</div>

HTML;


        return $html;
    }

    private $id;
    private $site;
}
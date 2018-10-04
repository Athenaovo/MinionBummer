<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 4/9/18
 * Time: 1:43 PM
 */

namespace Bummer;


class LobbyView extends View
{
    public function __construct(Site $site)
    {
        $this->site = $site;

        $this->addLink("post/logout.php", "Logout");
        $this->addLink("lobby.php", "Join Game");
        $this->addLink("instructions.php", "How to Play");
    }

    public function present() {
        // display lobbies
        $html = <<<HTML
<p>Welcome to Minion Bummer! Please select a game to join or create a new game.</p>
        
<form class="table" method="post" action="post/lobby.php">
<input type="submit" name="new" id="new" value="Start New Game">
	
HTML;

        $games = new Games($this->site);

        $all = $games->getGames();
        foreach($all as $game) {
            $id = $game->getId();
            $count = $game->getPlayerCount();
            $html .= <<<HTML
 <div class="lobbygames"><p><input type="radio" name="id" value="$id">Game $id: $count of 4 players</p></div>
HTML;
        }

        $html .= <<<HTML
    <input type="submit" name="join" id="join" value="Join Game!">

HTML;


            return $html;
    }
    private $site;
}
<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 4/8/18
 * Time: 8:37 PM
 */

namespace Bummer;


class StartNewGameView extends View
{

    public function __construct(){}

    // display lobbies
    public function present() {
        $html = <<<HTML
        <form method="post" action="post/startnewgame.php">
	<fieldset>
	<div class="welcomeLogin">

		<p><input type="submit" name = "addnew" value="Add New"></p>
</div>
	</fieldset>
</form>
HTML;

        return $html;
    }

}
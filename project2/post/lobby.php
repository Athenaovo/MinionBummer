<?php		// Can be accessed when not logged in
require '../lib/game.inc.php';

$controller = new Bummer\LobbyController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());
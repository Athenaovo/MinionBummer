<?php
$open = true;		// Can be accessed when not logged in
require '../lib/game.inc.php';

$controller = new Bummer\LoginController($bummer, $site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());
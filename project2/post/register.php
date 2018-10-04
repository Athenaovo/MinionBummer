<?php
$open = true;		// Can be accessed when not logged in
require '../lib/game.inc.php';
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

$controller = new Bummer\RegisterController($site, $_SESSION, $_POST);
header("location: " . $controller->getRedirect());
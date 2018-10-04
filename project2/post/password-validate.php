<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 8:17
 */
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

//comment out because the above one is easier to be test when connect with other stuffs
require '../lib/game.inc.php';

$controller = new Bummer\PasswordValidateController($site, $_POST);
header("location: " . $controller->getRedirect());
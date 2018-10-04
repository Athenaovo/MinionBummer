<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 10:07
// */
//echo "<pre>";
//print_r($_POST);
//echo "</pre>";

//comment out when everything is working then remove comment
require '../lib/game.inc.php';

$controller = new Bummer\ResetPasswordController($site, $_POST);
header("location: " . $controller->getRedirect());
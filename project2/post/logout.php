<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 3/18/18
 * Time: 6:16 PM
 */

require '../lib/game.inc.php';

// log out
unset($_SESSION[Bummer\User::SESSION_NAME]);
$user = null;

// redirect
header("location: ../index.php");
exit;
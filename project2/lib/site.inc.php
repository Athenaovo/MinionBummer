<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 4/9/18
 * Time: 11:27 AM
 */

$site = new Bummer\Site();

$localize = require 'localize.inc.php';
if(is_callable($localize)) {
    $localize($site);
}

// Start the session system for user
$user = null;
if(isset($_SESSION[Bummer\User::SESSION_NAME])) {
    $user = $_SESSION[Bummer\User::SESSION_NAME];
}


//
//// redirect if user is not logged in
//if(!isset($open) && $user === null) {
//    $root = $site->getRoot();
//    header("location: $root/");
//    exit;
//}
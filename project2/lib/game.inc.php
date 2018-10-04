<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 2/18/18
 * Time: 3:24 PM
 */

require __DIR__ . "/../vendor/autoload.php";
require 'site.inc.php';
// Start the PHP session system
session_start();

define("BUMMER_SESSION", 'bummer');

// If there is a Bummer session, use that. Otherwise, create one
if(!isset($_SESSION[BUMMER_SESSION])) {
    //temporary fix to remove errors, not sure how to actually fix this
    $row = array();
    $row['id'] = 0;
    $row['playerCount'] = 0;
    $row['status'] = 'O';
    $row['state'] = "";
    $row['id1'] = 0;
    $row['id2'] = 0;
    $row['id3'] = 0;
    $row['id4'] = 0;

    $_SESSION[BUMMER_SESSION] = new Bummer\Game($row);
}

$bummer = $_SESSION[BUMMER_SESSION];

$welcome = new Bummer\Welcome($_SESSION);



<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 2/19/18
 * Time: 3:10 PM
 */

use Bummer\Games;

require __DIR__ . '/lib/game.inc.php';

$id = strip_tags($_GET['id']);
$bummer->setId($id);
$wController = new \Bummer\WelcomeController($bummer, $welcome, $site, $id, $_POST);

// once we start game, should probs set status as closed
if ($bummer->getStatus() == "C" and $wController->isValid()) {
    $games = new Games($site);
    $games->setGameClosed($id);
    $bummer = $games->get($id);

    header("Location: game-post.php?id=$id");

    //when other players join the room auto refresh
    /*
     * PHP code to cause a push on a remote client.
//     */
//    $msg = json_encode(array('key' => 'teamken_upload', 'cmd' => 'reload'));
//
//    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//
//    $sock_data = socket_connect($socket, '127.0.0.1', 8078);
//    if (!$sock_data) {
//        echo "Failed to connect";
//    } else {
//        socket_write($socket, $msg, strlen($msg));
//    }
//    socket_close($socket);
//
//    exit;
}

/*echo "<pre>";
print_r($_POST);
echo "</pre>";
echo "ID: " . $bummer->getId();*/
header("Location: wait.php?id=$id");
//when other players join the room auto refresh
/*
 * PHP code to cause a push on a remote client.
 */
$msg = json_encode(array('key' => 'teamken_upload', 'cmd' => 'reload'));

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

$sock_data = socket_connect($socket, '127.0.0.1', 8078);
if (!$sock_data) {
    echo "Failed to connect";
} else {
    socket_write($socket, $msg, strlen($msg));
}
socket_close($socket);

exit;
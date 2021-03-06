<?php
require __DIR__ . '/lib/game.inc.php';
$id = strip_tags($_GET['id']);

$games = new \Bummer\Games($site);
$game = $games->get($id);
//$bummer = $game;

//echo $user->get

$controller = new \Bummer\GameController($id, $_POST, $site, $_SESSION);

header("location: game.php?id=$id");
//when other players take turn auto refresh
/*
 * PHP code to cause a push on a remote client.
 */
$msg = json_encode(array('key' => 'teamken_game', 'cmd' => 'reload'));

$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

$sock_data = socket_connect($socket, '127.0.0.1', 8078);
if (!$sock_data) {
    echo "Failed to connect";
} else {
    socket_write($socket, $msg, strlen($msg));
}
socket_close($socket);
exit;
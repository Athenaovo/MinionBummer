<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 2/19/18
 * Time: 1:15 AM
 */

use Bummer\Games;

require 'lib/game.inc.php';
$view = new Bummer\WaitView($site);

if(!$view->protect($site)) {
    header("location: " . $view->getProtectRedirect());
    exit;
}

$id = strip_tags($_GET['id']);
$games = new Games($site);
$game = $games->get($id);
$status = $game->getStatus();

if($status == 'C') {
    header("location: game-post.php?id=$id");
    exit;
}
?>

<script>
    /**
     * Initialize monitoring for a server push command.
     * @param key Key we will receive.
     */
    function pushInit(key) {
        var conn = new WebSocket('ws://webdev.cse.msu.edu/ws');
        conn.onopen = function (e) {
            console.log("Connection to push established!");
            conn.send(key);
        };

        conn.onmessage = function (e) {
            try {
                var msg = JSON.parse(e.data);
                if (msg.cmd === "reload") {
                    location.reload();
                }
            } catch (e) {
            }
        };
    }

    pushInit("teamken_upload");

</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Game is About to Start</title>
    <link href="style.css" type="text/css" rel="stylesheet" />

    <?php
    echo $view->makeNavBar($site);
    ?>

</head>
<body>
<?php
echo $view->present();
?>
</body>
</html>
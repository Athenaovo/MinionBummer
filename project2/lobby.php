<?php
/**
 * Created by PhpStorm.
 * User: Gus
 * Date: 4/01/18
 * Time: 2:55 AM
 */

require 'lib/game.inc.php';
$view = new \Bummer\LobbyView($site);
if(!$view->protect($site)) {
    header("location: " . $view->getProtectRedirect());
    exit;
}
$bummer->setStatus("O");
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

    pushInit("teamken_newgame");

</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Minion Bummer!</title>
    <link href="style.css" type="text/css" rel="stylesheet" />

    <?php
    echo $view->makeNavBar($site);
    ?>

</head>
<body>

<div class="welcomeLogin">
    <?php
    echo $view->present();
    ?>
</div>

</body>
</html>

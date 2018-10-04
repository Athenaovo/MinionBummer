<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 2/15/18
 * Time: 10:20 PM
 */

require 'lib/game.inc.php';

$view = new Bummer\View();
if(!$view->protect($site)) {
    header("location: " . $view->getProtectRedirect());
    exit;
}
$id = 0;
if(isset($_GET['id'])) {
    $id = strip_tags($_GET['id']);
}
$view = new Bummer\GameView($id, $site);

$viewWelcome = new Bummer\WelcomeView( $welcome );

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Minion Bummer</title>
    <link href="style.css" type="text/css" rel="stylesheet" />
    <?php
    echo $viewWelcome->makeNavBar($site);
    ?>
    <?php
    echo $view->displayMenu();
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
                // console.log(e);
                try {
                    var msg = JSON.parse(e.data);
                    if (msg.cmd === "reload") {
                        location.reload();
                    }
                    if (msg.cmd == "testing") {
                        console.log("testing received");
                    }
                } catch (e) {
                }
            };
        }

        pushInit("teamken_game");
    </script>
</head>
<body>


            <?php
                echo $view->presentForm();?>
        <div class="game">
            <?php
                echo $view->presentGameGrid();
                echo $view->presentPlayArea();
            ?>
        </div>

    </form>
</body>
</html>

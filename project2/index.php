<?php
/**
 * Created by PhpStorm.
 * User: Gus
 * Date: 4/01/18
 * Time: 2:55 AM
 */

require 'lib/game.inc.php';

$view = new Bummer\LoginView($_SESSION, $_GET);
$view->setTitle('Minion Bummer');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome to Minion Bummer!</title>
    <link href="style.css" type="text/css" rel="stylesheet" />

    <?php
    unset($_SESSION[BUMMER_SESSION]);
    echo $view->makeNavBar($site);
    ?>

</head>
    <body>

        <div class="welcomeLogin">

            <p>Welcome to Minion Bummer! Please enter your account credentials to log in.</p>

            <?php echo $view->presentForm() ?>

        </div>

    </body>
</html>

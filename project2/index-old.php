<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 2/19/18
 * Time: 1:15 AM
 */

require 'lib/game.inc.php';
$view = new Bummer\WelcomeView( $welcome );
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

        <p>Welcome to Minion Bummer! Please login or register to join a game!</p>
<!---->
<!--
<!--        <form method="post" action="welcome-post.php">-->
<!---->
<!--            <p>Player 1: <input type="text" name="player1"></p>-->
<!--            <p>Player 2: <input type="text" name="player2"></p>-->
<!--            <p>Player 3: <input type="text" name="player3"></p>-->
<!--            <p>Player 4: <input type="text" name="player4"></p>-->
<!---->
<!--            <input type="submit" value="Start Game!">-->
<!---->
<!--            <p>Please register two, three or four players with unique usernames!</p>-->

    </div>
    </body>
</html>
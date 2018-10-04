<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 2/19/18
 * Time: 1:15 AM
 */

require 'lib/game.inc.php';
$view = new Bummer\WelcomeView($welcome);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Instructions for Minion Bummer!</title>
    <link href="style.css" type="text/css" rel="stylesheet" />

    <?php
    echo $view->makeNavBar($site);
    ?>

</head>
<body>

<div class="instructions">

    <div class="instructiontext">

    <p>Minion Bummer is a game for two to four players. </p>

    <p>The object of the game is to move all three minions
        into the Home area by moving clockwise around the game board.</p>

    <p>Each player in turn draws one card from the deck and follows its instructions.
        To begin the game, all of a player's three Minions are restricted to Start.
        A player can only move them out onto the rest of the board if he or she
        draws a 1 or 2 card. A 1 or a 2 places a Minion on the space directly
        outside of start (a 2 does not entitle the pawn to move a second space).</p>

    <p>A Minion can jump over any other Minion during its move. However, two Minions
        cannot occupy the same square; a Minion that lands on a square occupied by
        another player's Minion "bumps" that Minion back to its own Start.</p>
    <p>If a Minion lands at the start of a slide, it immediately "slides" to the last
        square of the slide. All Minions on all spaces of the slide (including those
        belonging to the sliding player) are sent back to their respective Starts.</p>
    <p>The last five squares before each player's Home are "Safety Zones", and are specially
        colored corresponding to the colors of the Homes they lead to. Access is limited to
        Minions of the same color. Minions inside the Safety Zones are immune to being bumped
        by opponent's Minions or being switched with opponents' Minions via Bummer! cards.
        However, if a Minion is forced via a card to move backwards out of the Safety Zone,
        it is no longer considered "safe" and may be bumped by or switched with opponents'
        Minions as usual until it re-enters the Safety Zone.
    <p>You must enter the Home by an exact count. For example, a player who is three spaces
        from Home cannot use a 5 card to move into Home.</p>
    <p>At any time a player can choose to Pass, meaning they do not play the card.
         A player may have to pass if there are no possible moves.</p>
    <p>The first player to get all three Minions into Home wins.</p>
<!---->
<!--        <p class="return"><a href="game.php">Return to Game</a></p>-->

    </div>

</div>

</body>
</html>
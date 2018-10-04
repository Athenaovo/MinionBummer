<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 2/19/18
 * Time: 1:15 AM
 */

require 'lib/game.inc.php';
$view = new Bummer\StartNewGameView();
?>

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

<?php
echo $view->present();
?>

</body>
</html>
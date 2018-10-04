<?php
/**
 * Created by PhpStorm.
 * User: Gus
 * Date: 4/01/18
 * Time: 2:55 AM
 */

require 'lib/game.inc.php';
$view = new Bummer\RegisterView( $welcome );
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

<div class="welcomeLogin">

    <p>Welcome to Minion Bummer!</p>

    <?php echo $view->presentForm() ?>

</div>

</body>
</html>

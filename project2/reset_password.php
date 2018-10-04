<?php
$open = true;
require 'lib/game.inc.php';
$view = new Bummer\ResetPasswordView($welcome);
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
<div class="resetpassword">
    <?php
    echo $view->present();
    ?>
</div>

</body>
</html>
<?php
/**
 * Function to localize our site
 * @param $site The Site object
 */
return function(Bummer\Site $site) {
    // Set the time zone
    date_default_timezone_set('America/Detroit');

    $site->setEmail('quarlesh@cse.msu.edu');
    $site->setRoot('/~quarlesh/project2');
    $site->dbConfigure('mysql:host=mysql-user.cse.msu.edu;dbname=quarlesh',
        'quarlesh',       // Database user
        'ilovehummus',     // Database password
        'project2_');           // Table prefix
};
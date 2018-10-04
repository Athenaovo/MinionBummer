<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 4/1/18
 * Time: 7:00 PM
 */

namespace Bummer;

/*
 * copied from Step 8.
 */
class UsersController
{

    public function __construct(Site $site, User $user, array $post)
    {
        $root = $site->getRoot();
        $this->redirect = "$root/user.php";

        if((isset($post['edit']) or isset($post['delete']))
            and isset($post['user'])){
            // necessary? should be different page or nah?
            $this->redirect = "$root/user.php" . "?id=" . $post['user'];
        }

    }

    public function getRedirect(){
        return $this->redirect;
    }

    private $redirect;

}
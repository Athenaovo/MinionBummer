<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 4/1/18
 * Time: 7:14 PM
 */

namespace Bummer;


// Copied from Step 8.
class GamesController
{

    public function __construct(Site $site, array $post)
    {
        $root = $site->getRoot();

        if(isset($post['add'])){
            // change page probably?
            $this->redirect = "$root/newgame.php";
        }
        else if(isset($post['delete']) and isset($post['user'])){
            // is this necessary? at what point would users go here?
            $this->redirect = "$root/deletegame.php?id=" . $post['user'];
        }
        else{
            // change page probably?
            $this->redirect = "$root/index.php";
        }

    }

    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }

    private $redirect;

}
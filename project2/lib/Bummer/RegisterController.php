<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/4/18
 * Time: 1:47 PM
 */

namespace Bummer;


class RegisterController
{


    public function __construct(Site $site, array &$session, array $post) {
        // Create a Users object to access the table

        $users = new Users($site);

        $username = strip_tags($post['username']);
        $email = strip_tags($post['email']);
        $row = array('name'=>$username, 'email'=>$email, 'id'=>1); //id is temporary
        $user = new User($row);
        $user = $users->add($user);
        $session[User::SESSION_NAME] = $user;


        $root = $site->getRoot();

        if($user != null) {
            // Login failed
             $this->redirect = "$root/register.php?e";
        } else {
            if(isset($post['createUser'])){
                 $this->redirect = "$root";
            }

        }




    }


    /**
     * @return mixed
     */
    public function getRedirect()
    {
        return $this->redirect;
    }



    private $redirect;	///< Page we will redirect the user to.

}

<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 4/4/18
 * Time: 12:52 PM
 */

namespace Bummer;


class LoginController
{

    public function __construct(Game $bummer, Site $site, array &$session, array $post) {
        // Create a Users object to access the table
        $users = new Users($site);

        $email = strip_tags($post['email']);
        $password = strip_tags($post['password']);
        $user = $users->login($email, $password);
        $session[User::SESSION_NAME] = $user;

        $session["Error"] = "Invalid login credentials";

        $root = $site->getRoot();
        if($user === null) {
            if (isset($post['forgotPasswordButton'])){
                $this->redirect = "$root/reset_password.php?email=$email";
            }
            //Login failed
            else{
                $this->redirect = "$root/index.php?e";}
        }
        else {
            $this->redirect = "$root/lobby.php";
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
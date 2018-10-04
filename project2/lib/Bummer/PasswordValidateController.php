<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/5
 * Time: 16:40
 */

namespace Bummer;


class PasswordValidateController
{
    public function __construct(Site $site, array $post)
    {
        $root = $site->getRoot();
        $this->redirect = "$root/";
        if (isset($post['cancel'])) {
            $this->redirect = "$root/index-old.php";
            return;
        }

        //
        // 1. Ensure the validator is correct! Use it to get the user ID.
        //
        $validators = new Validators($site);
        $validator = strip_tags($post['validator']);
        $userid = $validators->get($validator);
        if($userid === null) {
            $session["ValidateError"] = "Invalid or unavailable validator";
            $this->redirect = "$root/password-validate.php?v=$validator&e";
            return;
        }

        //
        // 2. Ensure the email matches the user.
        //
        $users = new Users($site);
        $editUser = $users->get($userid);
        if($editUser === null) {
            // User does not exist!
            $session["ValidateError"] = "Email address is not for a valid user";
            $this->redirect = "$root/password-validate.php?v=$validator&e";
            return;
        }
        $email = trim(strip_tags($post['email']));
        if($email !== $editUser->getEmail()) {
            // Email entered is invalid
            $session["ValidateError"] = "Email address does not match validator";
            $this->redirect = "$root/password-validate.php?v=$validator&e";
            return;
        }

        //
        // 3. Ensure the passwords match each other
        //
        $password1 = trim(strip_tags($post['password']));
        $password2 = trim(strip_tags($post['password2']));

        if(strlen($password1) < 8) {
            // Password too short
            $session["ValidateError"] = "Password too short";
            $this->redirect = "$root/password-validate.php?v=$validator&e";
            return;
        }
        if($password1 !== $password2) {
            // Passwords do not match
            $session["ValidateError"] = "Passwords did not match";
            $this->redirect = "$root/password-validate.php?v=$validator&e";
            return;
        }

        //
        // 4. Create a salted password and save it for the user.
        //
        $users->setPassword($userid, $password1);

        //
        // 5. Destroy the validator record so it can't be used again!
        //
        $validators->remove($userid);
    }

    public function getRedirect()
    {
        return $this->redirect;
    }


    private $redirect;	///< Page we will redirect the user to.
}
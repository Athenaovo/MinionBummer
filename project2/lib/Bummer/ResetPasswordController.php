<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/5
 * Time: 17:13
 */

namespace Bummer;


class ResetPasswordController
{
    public function __construct(Site $site, array $post)
    {
        $root = $site->getRoot();
        $email = $post['email'];
        if (isset($post['yes'])) {
            $users = new Users($site);
            $user = $users->getbyEmail($email);
            $id = $user->getId();
            $validators = new Validators($site);
            $old = $validators->remove($id);
            $validator = $validators->newValidator($id);
            // Send email with the validator in it
            $link = "http://webdev.cse.msu.edu"  . $site->getRoot() .
                '/password-validate.php?v=' . $validator;

            $from = $site->getEmail();
            $name = $user->getName();

            $subject = "Confirm your email";
            $message = <<<MSG
<html>
<p>Greetings, $name,</p>

<p>Welcome to Bummer. In order to complete your registration,
please verify your email address by visiting the following link:</p>

<p><a href="$link">$link</a></p>
</html>
MSG;
            $headers = "MIME-Version: 1.0\r\nContent-type: text/html; charset=iso=8859-1\r\nFrom: $from\r\n";
            $mailer = new Email();
            $mailer->mail($user->getEmail(), $subject, $message, $headers);
//        */
            //if ($del == true) {
                $this->redirect = "$root/index.php?reset=yes";
           // }
        }
        elseif (isset($post['back'])){
            $this->redirect = "$root/index.php";
        }
        else{
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


}
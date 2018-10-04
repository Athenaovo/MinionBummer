<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 9:05
 */

namespace Bummer;


class ResetPasswordView extends View
{
    public function present(){
        $email = $_GET['email'];

        if($email ==""){
            $html = <<<HTML
<form method="post" action = "post/resetpassword.php">
	<fieldset>
	<input type="hidden" name="email" value="$email">
	
		<legend>Reset Password?</legend>
		<p>please enter your email and then click on reset password button</p>

		<p>Speak now or forever hold your peace.</p>

		<p><input type="submit" name = "back" value="back"></p>

	</fieldset>
</form>
HTML;

        }
        else {
            $html = <<<HTML
<form method="post" action = "post/resetpassword.php">
	<fieldset>
	<input type="hidden" name="email" value="$email">
	
		<legend>Reset Password?</legend>
		<p>Are you sure absolutely certain beyond a shadow of
			a doubt that you want to reset the password of $email?</p>
		<p>Check your email after you clicked Yes.</p>

		<p>Speak now or forever hold your peace.</p>

		<p><input type="submit" name = "yes" value="Yes"> <input type="submit" name = "no" value="No"></p>

	</fieldset>
</form>
HTML;
        }

        return $html;
    }

}
<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/4/2
 * Time: 6:46
 */

namespace Bummer;


class PasswordValidateView extends View
{
    const VALIDATOR =1;
    const INVALIDUSER = 2;
    const INVALIDEMAIL = 3;
    const INVALIDPASS = 4;
    const TOOSHORT = 5;

    /**
     * Constructor
     * @param $site Site
     * @param $get
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site, $get) {
        $this->site = $site;
        $this->validator = strip_tags($get['v']);

        if(isset($_SESSION["ValidateError"])) {
            $this->errorMsg = $_SESSION["ValidateError"];
        }
        if(isset($get['e'])) {
            $this->error = true;
        }
    }

    public function present(){
        $html = "";
        if ($this->error) {
            $html .= '<p class="msg">' . $this->errorMsg .'</p>';
        }
        $html .= <<<HTML
<form method="post" action="post/password-validate.php">
    <input type="hidden" name="validator" value="$this->validator">
    <fieldset>
        <legend>Change Password</legend>
        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Email">
        </p>
        <p>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" placeholder="Password">
        </p> 
        <p>
            <label for="password">Password (again)</label><br>
            <input type="password" id="password" name="password2" placeholder="Password">
        </p>                 
        <p>
            <input type="submit" name = "ok" value="OK"> <input type="submit" name = "cancel" value="Cancel">
        </p>
HTML;
        if(isset($_GET['e'])) {
            $html .= "<p class=\"msg\">Invalid or unavailable password changes </p>";
        }
        $html .= <<<HTML
	</fieldset>
</form>
HTML;
        return $html;

    }
    private $validator;
    private $errorMsg = "";
    private $error = false;
}
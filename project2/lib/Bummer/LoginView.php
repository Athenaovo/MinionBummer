<?php

namespace Bummer;

class LoginView extends View {

    public function __construct(array &$session, array $get)
    {
        if(isset($session["Error"])) {
            $this->errorMsg = $session["Error"];
        }
        if(isset($get['e'])) {
            $this->error = true;
        }

        $this->addLink("register.php", "Register");
        $this->addLink("index.php", "Login");
        $this->addLink("instructions.php", "How to Play");
    }

    public function presentForm() {
        $html = "";
        if ($this->error) {
            $html .= '<p class="msg">' . $this->errorMsg .'</p>';
        }
        $html .= <<<HTML
<form method="post" action="post/login.php">
    <fieldset>
        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Email">
        </p>
        <p>
            <label for="password">Password</label><br>
            <input type="password" id="password" name="password" placeholder="Password">
        </p>
        <p>
            <input type="submit" value="Log in" name ="loginButton" id="loginButton"> 
            <input type="submit" value="Forgot Password" name="forgotPasswordButton" id="forgotPasswordButton">
        </p>
    </fieldset>
</form>
HTML;

        return $html;
    }


    private $errorMsg = "";
    private $error = false;
}
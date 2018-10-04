<?php

namespace Bummer;

class RegisterView extends View {

    public function __construct()
    {
        $this->addLink("register.php", "Register");
        $this->addLink("index.php", "Login");
        $this->addLink("instructions.php", "How to Play");
    }

    public function presentForm() {
        $html = <<<HTML
<form method="post" action="post/register.php">
    <fieldset>
        <p>
            <label for="email">Email</label><br>
            <input type="email" id="email" name="email" placeholder="Email">
        </p>
                <p>
            <label for="username">Username</label><br>
            <input type="text" id="username" name="username" placeholder="Username">
        </p>
        <p>
            <input type="submit" value="Create User" id="createUser" name="createUser"> 
        </p>
    </fieldset>
</form>
HTML;

        return $html;
    }
}
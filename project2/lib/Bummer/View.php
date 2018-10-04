<?php

namespace Bummer;

/**
 * Base class for all views
 */
class View {

    public function protect($site)
    {
        if (isset($_SESSION[User::SESSION_NAME])) {
            return true;
        } else {
            $this->protectRedirect = $site->getRoot() . "/";
            return false;
        }
    }


    /**
     * Create the HTML for the page footer
     * @return string HTML for the standard page footer
     */
    public function footer()
    {
        return <<<HTML
HTML;
    }

    /**
     * Create the HTML for the contents of the head tag
     * @return string HTML for the page head
     */
    public function head() {
        return <<<HTML
<meta charset="utf-8">
<title>$this->title</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="../../style.css">
HTML;
    }

    /**
     * Create the HTML for the page header
     * @return string HTML for the standard page header
     */
    public function header() {
        $html = <<<HTML
HTML;
        return $html;
    }

    /**
     * Override in derived class to add content to the header.
     * @return string Any additional comment to put in the header
     */
    protected function headerAdditional() {
        return '';
    }

    /**
     * Set the page title
     * @param $title New page title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Add a link that will appear on the nav bar
     * @param $href string to link to
     * @param $text
     */
    public function addLink($href, $text) {
        $this->links[] = array("href" => $href, "text" => $text);
    }


    /**
     * Get any redirect page
     */
    public function getProtectRedirect() {
        return $this->protectRedirect;
    }


    /* added by Rachel
     * Creates navigation for all the pages
     * Includes Welcome, Instructions, and Game
     */
    public function makeNavBar(Site $site){

        $html = <<< HTML
        <div class="header">
        <ul>
        <b>
        
HTML;

        foreach($this->links as $link) {
            $html .= '<li><a href="' .
                $link['href'] . '">' .
                $link['text'] . '</a></li>';
        }

        $html .= <<< HTML
        </b>
        </ul>
        <h1>Minion Bummer!</h1>
HTML;
        if (isset($_SESSION[User::SESSION_NAME])) {
            $users = new Users($site);
            $user = ($_SESSION[User::SESSION_NAME]);
            $username = $user->getName();
            $html .= "<h2>Welcome, $username!</h2>";
        }

        $html .= <<< HTML
        </div>
HTML;

        return $html;

    }

    /// Page protection redirect
    private $protectRedirect = null;

    private $title = "Minion Bummer";	///< The page title
    private $links = array();	///< Links to add to the nav bar
}
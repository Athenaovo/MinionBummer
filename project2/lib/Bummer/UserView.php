<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 4/1/18
 * Time: 2:46 PM
 */

namespace Bummer;


class UserView extends View
{
    /**
     * Constructor
     * Sets the page title and any other settings.
     */
    public function __construct(Site $site, $get) {
        $this->site = $site;

        $this->setTitle("Minion Bummer");


    }

    public function present() {
        $html = <<<HTML

HTML;

        return $html;
    }

    private $id;
    private $email;
    private $name;

}
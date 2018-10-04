<?php
/**
 * Created by PhpStorm.
 * User: hayleequarles
 * Date: 3/18/18
 * Time: 9:49 PM
 */

namespace Bummer;

// HOW WILL WE CONNECT USESR TO PLAYER? SHOULD THEY BE CONNECTED?
//      IF SO, HOW? SHOULD USER JUST HAVE PRIVATE PLAYER MEMBER?

class User
{
    const SESSION_NAME = 'user';

    /**
     * Constructor
     * @param $row Row from the user table in the database
     */
    public function __construct($row) {
        $this->id = $row['id'];
        $this->email = $row['email'];
        $this->name = $row['name'];

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getGameid()
    {
        return $this->gameid;
    }

    /**
     * @param mixed $gameid
     */
    public function setGameid($gameid)
    {
        $this->gameid = $gameid;
    }

    private $id;		///< The internal ID for the user
    private $email;		///< Email address
    private $name; 		///< Name as player username
    private $gameid;


}
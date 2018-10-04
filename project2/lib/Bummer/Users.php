<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 4/1/18
 * Time: 6:44 PM
 */

namespace Bummer;

/*
 * Copied from Step 8.
 * Do we need UsersView? Why would we need to view all the users?
 */

class Users extends Table
{

    /**
     * Constructor
     * @param $site The Site object
     */
    public function __construct(Site $site) {
        parent::__construct($site, "user");
    }

    /**
     * Modify a user record based on the contents of a User object
     * @param User $user User object for object with modified data
     * @return true if successful, false if failed or user does not exist
     * Copied from Step 8.
     * Assuming we can punt on address, phone number, and role.
     */
    public function update(Player $user) {
        $sql = <<<SQL
UPDATE $this->tableName
SET email = ? , name = ?
WHERE id = ?
SQL;
//we dont have notes in our sql . i removed

        // get stuff from $user
        $email = $user->getEmail();
        $name = $user->getName();

        $id = $user->getId();

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $ret = $statement->execute(array($email, $name, $id));
        } catch(\PDOException $e) {
            print_r("***ERROR1: ");
            print_r($e);
            return false;
        }

        if($statement->rowCount() <= 0){
            print_r("***ERROR2: ");
            print_r($statement->rowCount());
            return false;
        }

        return true;

    }

    /**
     * Test for a valid login.
     * @param $email User email
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     * Copied from Step 8.
     * Unchanged.
     */
    /**
     * Test for a valid login.
     * @param $email User emailxs
     * @param $password Password credential
     * @returns User object if successful, null otherwise.
     */
    public function login($email, $password) {
        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return null;
        }
        $row = $statement->fetch(\PDO::FETCH_ASSOC);

        // Get the encrypted password and salt from the record
        $hash = $row['password'];
        $salt = $row['salt'];

        // Ensure it is correct
        if($hash !== hash("sha256", $password . $salt)) {
            return null;
        }

        return new User($row);
    }


    /**
     * Get a user based on the id
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
     * Copied from Step 8.
     */
    public function get($id) {

        $sql =<<<SQL
SELECT * from $this->tableName
where id=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($id));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));

    }
    /**
     * Get a user based on the email
     * @param $id ID of the user
     * @returns User object if successful, null otherwise.
     * Copied from Step 8.
     */
    public function getbyEmail($email) {

        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return null;
        }

        return new User($statement->fetch(\PDO::FETCH_ASSOC));

    }

    /*
     * returns an array of users.
     * Not sure if this will be used or not.
     */
    public function getUsers(){

        $sql = <<<SQL
SELECT * from $this->tableName
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $ret = $statement->execute(array());
        } catch(\PDOException $e) {
            print_r("***ERROR1: ");
            print_r($e->getMessage());
            print_r($this->getTableName());
            return null;
        }

        if($statement->rowCount() <= 0){
            print_r("***ERROR2: ");
            print_r($statement->rowCount());
            return null;
        }

        if($ret){
            $result = $statement->fetchALL(\PDO::FETCH_ASSOC);
            return $result;
        }

        return null;

    }

    /**
     * Create a new user.
     * @param User $user The new user data
     * @param Email $mailer An Email object to use
     * @return null on success or error message if failure
     * Copied from Step 8.
     * Phone, address, and role removed.
     */
    public function add(User $user) { //, Email $mailer (removed mailer parameter, see below)
        // Ensure we have no duplicate email address
        if($this->exists($user->getEmail())) {
            return "Email address already exists.";
        }

        // Add a record to the user table
        $sql = <<<SQL
INSERT INTO $this->tableName(email, name, joined)
values(?, ?, ?)
SQL;

        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array(
            $user->getEmail(), $user->getName(), date("Y-m-d H:i:s") ));
        $id = $this->pdo()->lastInsertId();

        //commmented this  becausewe don't have email confirmation functionality yet, so uncomment when that works
//        /*

        // Create a validator and add to the validator table
        $validators = new Validators($this->site);
        $validator = $validators->newValidator($id);

        // Send email with the validator in it
        $link = "http://webdev.cse.msu.edu"  . $this->site->getRoot() .
            '/password-validate.php?v=' . $validator;

        $from = $this->site->getEmail();
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
    }

    /**
     * Set the password for a user
     * @param $userid The ID for the user
     * @param $password New password to set
     * Copied from Step 8.
     */
    public function setPassword($userid, $password) {

        $salt = $this->randomSalt();
        $hash = hash("sha256", $password . $salt);

        $sql = <<<SQL
UPDATE $this->tableName
SET password = ?, salt = ?
WHERE id = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $ret = $statement->execute(array($hash, $salt, $userid));
        } catch(\PDOException $e) {
            print_r("***ERROR1: ");
            print_r($e);
            return false;
        }

        if($statement->rowCount() <= 0){
            print_r("***ERROR2: ");
            print_r($statement->rowCount());
            return false;
        }

        return true;

    }

    /**
     * Generate a random salt string of characters for password salting
     * @param $len Length to generate, default is 16
     * @returns Salt string
     * Copied from Step 8.
     */
    public static function randomSalt($len = 16) {
        $bytes = openssl_random_pseudo_bytes($len / 2);
        return bin2hex($bytes);
    }


    /**
     * Determine if a user exists in the system.
     * @param $email An email address.
     * @returns true if $email is an existing email address
     */
    public function exists($email) {

        $sql =<<<SQL
SELECT * from $this->tableName
where email=?
SQL;


        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($email));
        if($statement->rowCount() === 0) {
            return false;
        }

        return true;

    }


}
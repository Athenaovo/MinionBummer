<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 3/28/18
 * Time: 3:17 AM
 */

namespace Bummer;


class Validators extends Table {

    /**
     * Constructor
     * @param $site The Site object
     * Copied from Step 8.
     */
    public function __construct(Site $site) {
        parent::__construct($site, "validator");
    }

    /**
     * Generate a random validator string of characters
     * @param $len Length to generate, default is 32
     * @returns Validator string
     * Copied from Step 8.
     */
    public function createValidator($len = 32) {
        $bytes = openssl_random_pseudo_bytes($len / 2);
        return bin2hex($bytes);
    }

    /**
     * Create a new validator and add it to the table.
     * @param $userid User this validator is for.
     * @return The new validator.
     * Copied from Step 8.
     */
    public function newValidator($userid) {
        $validator = $this->createValidator();

        // Write to the table
        $sql = <<<SQL
INSERT INTO $this->tableName(userid, validator, date)
values(?, ?, ?)
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        try {
            $ret = $statement->execute(array($userid, $validator, date("Y-m-d H:i:s")));
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

        return $validator;
    }

    /**
     * Determine if a validator is valid. If it is,
     * return the user ID for that validator.
     * @param $validator Validator to look up
     * @return User ID or null if not found.
     * Copied from Step 8.
     */
    public function get($validator) {

        $sql =<<<SQL
SELECT userid from $this->tableName
where validator=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($validator));
        if($statement->rowCount() === 0) {
            return null;
        }

        $result = $statement->fetch(\PDO::FETCH_ASSOC);

        return $result['userid'];

    }

    /**
     * Remove any validators for this user ID.
     * @param $userid The USER ID we are clearing validators for.
     * Copied from Step 8.
     */
    public function remove($userid) {

        $sql =<<<SQL
DELETE FROM $this->tableName
where userid=?
SQL;
        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($userid));

    }


}
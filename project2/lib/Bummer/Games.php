<?php
/**
 * Created by PhpStorm.
 * User: Rachel
 * Date: 4/1/18
 * Time: 7:03 PM
 */

namespace Bummer;

require_once("Table.php");

class Games extends Table
{

    public function __construct(Site $site) {
        parent::__construct($site, "game");
    }

    public function add(Game $game) {
    echo "ADD\n";
    echo $game->getPlayerCount() . "\n";
    echo $this->tableName . "\n";
        // Add a record to the game table
        $sql = <<<SQL
INSERT INTO $this->tableName(playerCount, status, state, id1, id2, id3, id4)
values(?, ?, ?, ?, ?, ?, ?)
SQL;
        $statement = $this->pdo()->prepare($sql);
        $statement->execute(array($game->getPlayerCount(), $game->getStatus(), $game->getState(), $game->getId1(), $game->getId2(), $game->getId3(), $game->getId4()));

       // $game->setId($this->pdo()->lastInsertId());
        return $this->pdo()->lastInsertId();
    }


    /**
     * Get a case by id
     * @param $id The case by ID
     * @returns Object that represents the case if successful,
     *  null otherwise.
     * Copied from Step 8.
     */
    public function get($id) {

        $sql = <<<SQL
SELECT id, playerCount, status, state, id1, id2, id3, id4
FROM $this->tableName
WHERE id = ?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute(array($id));

        $arr = $statement->fetchAll(\PDO::FETCH_ASSOC);



        $game = new Game();
        foreach ($arr as $game_data) {

            $game->setId($game_data['id']);
            $game->setPlayerCount($game_data['playerCount']);
            $game->setStatus($game_data['status']);
            $game->setState($game_data['state']);
            $game->setId1($game_data['id1']);
            $game->setId2($game_data['id2']);
            $game->setId3($game_data['id3']);
            $game->setId4($game_data['id4']);

        }

        return $game;


    }
//
//    /*
//     * Copied from Step 8.
//     */
//    public function insert($user) {
//        $sql = <<<SQL
//insert into $this->tableName(user, status)
//values(?, ?)
//SQL;
//
//        $pdo = $this->pdo();
//        $statement = $pdo->prepare($sql);
//
//        try {
//            if($statement->execute(array($user,
//                        'O')
//                ) === false) {
//                return null;
//            }
//        } catch(\PDOException $e) {
//            return null;
//        }
//
//        return $pdo->lastInsertId();
//    }

    /*
     * Copied from Step 8.
     * Why would we need to get more than one game?
     * ^ For the lobbies page...
     * ^ Yep. Only getting open games now...
     */
    public function getGames(){

        // WILL PROBABLY HAVE TO CHANGE QUERY DEPENDING ON HOW WE SET UP DATABASE
        // add status probably

        $sql = <<<SQL
SELECT id, playerCount, status, state, id1, id2, id3, id4
FROM $this->tableName
WHERE status = "O"
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);
        $statement->execute();

        $games = array();

        $arr = $statement->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($arr as $game_data) {
            $game = new Game();

            $game->setId($game_data['id']);
            $game->setPlayerCount($game_data['playerCount']);
            $game->setStatus($game_data['status']);
            $game->setState($game_data['state']);
            $game->setId1($game_data['id1']);
            $game->setId2($game_data['id2']);
            $game->setId3($game_data['id3']);
            $game->setId4($game_data['id4']);


            $games[] = $game;
        }

        return $games;

    }

    /*
     * Copied from Step 8.
     */
    public function update(Game $game) {
        $sql =<<<SQL
SELECT * from $this->tableName
where id=?
SQL;
        $sql2 =<<<SQL
UPDATE $this->tableName
SET playerCount=?, status=?, state=?, id1=?, id2=?, id3=?, id4=?
where id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($game->getId()));
        if($statement->rowCount() === 0) {
            return false;
        }

        $pdo = $this->pdo();
        $statement2 = $pdo->prepare($sql2);

        try {
            $statement2->execute(array($game->getPlayerCount(), $game->getStatus(), $game->getState(), $game->getId1(), $game->getId2(), $game->getId3(), $game->getId4(), $game->getId()));


        } catch(\PDOException $e) {
            return false;
        }

        return true;


    }

    /*
     */
    public function setGameClosed($gameid) {
        $sql =<<<SQL
UPDATE $this->tableName
SET status="C"
where id=?
SQL;

        $pdo = $this->pdo();
        $statement = $pdo->prepare($sql);

        $statement->execute(array($gameid));
        if($statement->rowCount() === 0) {
            return false;
        }

        return true;


    }
//
//    /**
//     * Delete a case by id
//     * @param $id The case by ID
//     * @returns True if successful, false if not.
//     * Copied from Step 8.
//     */
//    public function delete($id) {
//
//        $sql = <<<SQL
//DELETE FROM $this->tableName
//WHERE id = ?
//SQL;
//
//        $pdo = $this->pdo();
//        $statement = $pdo->prepare($sql);
//
//        try {
//            $ret = $statement->execute(array($id));
//        } catch(\PDOException $e) {
//            print_r("***ERROR1: ");
//            print_r($e->getMessage());
//            return null;
//        }
//
//        if($statement->rowCount() <= 0){
//            print_r("***ERROR2: ");
//            print_r($statement->rowCount());
//            return null;
//        }
//
//        return boolval($ret);
//
//    }

}
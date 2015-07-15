<?php
require_once('db.php');

class Query
{
    private $db;
    private $server;
    private $user;
    private $pw;
    private $prt;
    private $dbn;
    private $tbl;

    public function __Construct($servername, $username, $password, $db_name,
                                $port, $table) {
        $this->server = $servername;
        $this->user = $username;
        $this->pw = $password;
        $this->dbn = $db_name;
        $this->prt = $port;
        $this->tbl = $table;
        $this->db = new Db($this->server, $this->user, $this->pw, $this->dbn,
            $this->prt);
    }

    public function select() {
        $command = 'SELECT * FROM ' . $this->tbl . ';';
        $data = $this->db->fetch($command);
        return $data;
    }

//    public function insert($title, $description, $date) {
//        $temp = 'INSERT INTO ' . $this->tbl . ' (`title`, `description`, `date`)
//         VALUES ( "' . $title . '", "' . $description . '", "' . $date . '");';
//        echo $temp . "\n";
//        $result = $this->db->execute($temp);
//        return $result;
//    }
    /* insert: enter args as (key,value,key,value...) */
    public function insert() {
        $args = func_get_args();
        $start_datetime = $end_datetime = $name = $location = $description =
            $facebook_link = $instagram_link = $twitter_link = $misc_link =
                $profile = 0;
        foreach ($args as $key=>$arg) {
            if ($arg === "start_datetime") {
                $start_datetime = $args[$key + 1];
            }
            if ($arg === "end_datetime") {
                $end_datetime = $args[$key + 1];
            }
            if ($arg === "name") {
                $name = $args[$key + 1];
            }
            if ($arg === "location") {
                $location = $args[$key + 1];
            }
            if ($arg === "description") {
                $description = $args[$key + 1];
            }
            if ($arg === "facebook_link") {
                $facebook_link = $args[$key + 1];
            }
            if ($arg === "instagram_link") {
                $instagram_link = $args[$key + 1];
            }
            if ($arg === "twitter_link") {
                $twitter_link = $args[$key + 1];
            }
            if ($arg === "misc_link") {
                $misc_link = $args[$key + 1];
            }
            if ($arg === "profile") {
                $profile = $args[$key + 1];
            }
        }
        $command = 'INSERT INTO ' . $this->tbl . '(`start_datetime`,
            `end_datetime`, `name`, `location`, `description`, `facebook_link`,
            `instagram_link`, `twitter_link`, `misc_link`, `profile`) VALUES ('
            . $start_datetime . ', ' . $end_datetime . ', "' . $name . '", "' .
            $location . '", "' . $description . '", "' . $facebook_link . '", "' .
            $instagram_link . '", "' . $twitter_link . '", "' . $misc_link . '", "' .
            $profile . '");';
        echo $command;
        $this->db->execute($command);

    }

    public function delete($id) {
        $temp = 'DELETE FROM ' . $this->tbl . ' WHERE id = "' . $id . '";';
        $result = $this->db->execute($temp);
    }

    /* update: enter args as (key,value,key,value).  id represents entry to be
    updated */
    public function update() {
        $args = func_get_args();
        foreach ($args as $key=>$arg) {
            if ($arg === "id") {
                $id = $args[$key+1];
            } elseif ($arg === "title") {
                $title = $args[$key+1];
            } elseif ($arg === "description") {
                $description = $args[$key+1];
            } elseif ($arg === "date") {
                $date = $args[$key+1];
            }
        }
        if (isset($id)) { //only update if id is sent
            $result = $this->db->fetch('SELECT * from `events` WHERE id = ' . $id . ';');
            //fetch the item and set parameters equal to original
            if (!isset($title)) {
                $title = $result[0]["title"];
            }
            if (!isset($description)) {
                $description = $result[0]["description"];
            }
            if (!isset($date)) {
                $date = $result[0]["date"];
            }
        }
        //UPDATE $table SET id=$id, title=$title, description=$description, date=$date
        $command = 'UPDATE ' . $this->tbl  . ' SET title="' . $title . '",
        description="' . $description . '", date=' . $date . ' WHERE id=' .
            $id . ';';
        $this->db->execute($command);
    }
}

?>
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
                                $port) {
        $this->server = $servername;
        $this->user = $username;
        $this->pw = $password;
        $this->dbn = $db_name;
        $this->prt = $port;
        $this->db = new Db($this->server, $this->user, $this->pw, $this->dbn,
            $this->prt);
    }

    public function select($mode) { //set mode to indicate sort by time, etc.
        if ($mode === "all") {
            $command = 'SELECT * FROM events;';
            $data = $this->db->fetch($command);
        }
//        if ($mode === "future") {
//            $command = 'SELECT * FROM events WHERE
//            start_datetime > NOW();'
//        }
        return $data;
    }

    /* insert: enter args as (key,value,key,value...) */
    public function insert() {
        $args = func_get_args();
        $start_datetime = $end_datetime = $name = $location = $description =
        $facebook_link = $instagram_link = $twitter_link = $misc_link = 0;
        foreach ($args as $key => $arg) {
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
        }
        $command = 'INSERT INTO events (start_datetime, end_datetime, name,
          location, description, facebook_link, instagram_link, twitter_link,
          misc_link) VALUES ("' . $start_datetime . '", "' . $end_datetime .
            '", "' . $name . '", "' . $location . '", "' . $description . '", "'
            . $facebook_link . '", "' . $instagram_link . '", "' . $twitter_link
            . '", "' . $misc_link . '");';
        $this->db->execute($command);
    }

    public function delete($id) {
        $temp = 'DELETE FROM events WHERE id = "' . $id . '";';
        $this->db->execute($temp);
    }

    /* update: enter args as (key,value,key,value).  id represents entry to be
    updated */
    public function update() {
        $args = func_get_args();
        $start_datetime = $end_datetime = $name = $location = $description =
            $facebook_link = $instagram_link = $twitter_link = $misc_link = 0;
        foreach ($args as $key => $arg) {
            if ($arg === "id") {
                $id = $args[$key + 1];
            } elseif ($arg === "start_datetime") {
                $start_datetime = $args[$key + 1];
            } elseif ($arg === "end_datetime") {
                $end_datetime = $args[$key + 1];
            } elseif ($arg === "name") {
                $name = $args[$key + 1];
            }elseif ($arg === "location") {
                $location = $args[$key + 1];
            }elseif ($arg === "description") {
                $description = $args[$key + 1];
            }elseif ($arg === "facebook_link") {
                $facebook_link = $args[$key + 1];
            }elseif ($arg === "instagram_link") {
                $instagram_link = $args[$key + 1];
            }elseif ($arg === "twitter_link") {
                $twitter_link = $args[$key + 1];
            }elseif ($arg === "misc_link") {
                $misc_link = $args[$key + 1];
            }
        }
        if (isset($id)) { //only update if id is sent
            $result = $this->db->fetch('SELECT * from events WHERE id = ' . $id
                . ';');
            //fetch the item and set parameters equal to original
            if (!isset($start_datetime)) {
                $start_datetime = $result[0]["start_datetime"];
            }
            if (!isset($end_datetime)) {
                $end_datetime = $result[0]["end_datetime"];
            }
            if (!isset($name)) {
                $name = $result[0]["name"];
            }
            if (!isset($location)) {
                $location = $result[0]["location"];
            }
            if (!isset($description)) {
                $description = $result[0]["description"];
            }
            if (!isset($facebook_link)) {
                $facebook_link = $result[0]["facebook_link"];
            }
            if (!isset($instagram_link)) {
                $instagram_link = $result[0]["instagram_link"];
            }
            if (!isset($twitter_link)) {
                $twitter_link = $result[0]["twitter_link"];
            }
            if (!isset($misc_link)) {
                $misc_link = $result[0]["misc_link"];
            }
            $command = 'UPDATE events SET start_datetime="' . $start_datetime .
                '", end_datetime="' . $end_datetime . '", name="' . $name . '",
                location="' . $location . '", description="' . $description .
                '", facebook_link="' . $facebook_link . '", instagram_link="' .
                $instagram_link . '", twitter_link="' . $twitter_link . '",
                misc_link="' . $misc_link . '" WHERE event_id=' . $id . ';';
            echo $command;
            $this->db->execute($command);
        }
    }
}

?>
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

    public function select() { //set mode to indicate sort by time, etc.
        $args = func_get_args();
        if (count($args) === 0) {
            $result = $this->db->fetch();
        } elseif ($args[0] === "upcoming") {
            $result = $this->db->fetch("upcoming");
        } elseif ($args[0] === "passed") {
            $result = $this->db->fetch("passed");
        } elseif ($args[0] === "id") {
            $result = $this->db->fetch($args[0], $args[1]);
        } elseif ($args[0] === "attends") {
            $result = $this->db->fetch($args[0], $args[1]);
        } elseif ($args[0] === "allImages") {
            $result = $this->db->fetch("allImages");
        }
        return $result;
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
        $this->db->execute("insert", $start_datetime, $end_datetime, $name,
            $location, $description, $facebook_link, $instagram_link,
            $twitter_link, $misc_link);
    }

    public function delete($id) {
        $this->db->execute("delete", $id);
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
            $result = $this->db->fetch("id", $id);
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
            $this->db->execute("update", $id, $start_datetime, $end_datetime,
                $name, $location, $description, $facebook_link, $instagram_link,
                $twitter_link, $misc_link);
        }
    }
}

?>
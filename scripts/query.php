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

    public function insert($title, $description, $date) {
        $temp = 'INSERT INTO ' . $this->tbl . ' (`title`, `description`, `date`)
         VALUES ( "' . $title . '", "' . $description . '", "' . $date . '");';
        echo $temp . "\n";
        $result = $this->db->execute($temp);
        return $result;
    }

    public function delete($id) {
        $temp = 'DELETE FROM ' . $this->tbl . ' WHERE id = "' . $id . '";';
        $result = $this->db->execute($temp);
    }

    public function update() { //enter args as key,value,key,value,...
        //id represents the entry to be updated
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
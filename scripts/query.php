<?php
require_once('db.php');

class Query {
    private $db;
    private $server;
    private $user;
    private $pw;
    private $prt;
    private $dbn;
    private $tbl;

    public function __Construct($servername, $username, $password, $db_name, $port, $table) {
        $this->server = $servername;
        $this->user = $username;
        $this->pw = $password;
        $this->dbn = $db_name;
        $this->prt = $port;
        $this->tbl = $table;
        $this->db = new Db($this->server, $this->user, $this->pw, $this->dbn, $this->prt);
    }

//    public function select($option) {
//        if (($option === 1) || ($option === 2) || ($option === 3)) { //Web
//            $command = "SELECT * FROM projects WHERE category = " . $option;
//            $data = $this->db->fetch($command);
//        } else if ($option === 4) { //other
//            $command = "SELECT * FROM projects";
//            $data = $this->db->fetch($command);
//        } else {
//            echo "invalid select option\n";
//        }
//        return $data;
//    }
//
    public function insert ($title, $description, $date) {
        $temp = 'INSERT INTO '. $this->tbl . ' (`title`, `description`, `date`) VALUES ( "'.$title.'", "'.$description.'", "'.$date.'");';
        echo $temp . "\n";
        $result = $this->db->execute($temp);
        return $result;
    }

    public function delete ($id) {
        $temp = 'DELETE FROM ' .$this->tbl. ' WHERE id = "'.$id.'";';
        echo $temp;
        $result = $this->db->execute($temp);
        if ($result) {
            echo "Record Deleted Successfully with id #" . $id;
        }
        else {
            echo "Error Deleting Record";
        }
    }
}
?>
<?php
class Db {

    private $conn;

    public function __construct($servername, $username, $password, $db_name, $port) {
        $this->conn = new mysqli($servername, $username, $password, $db_name, $port);
        if ($this->conn->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->conn->connect_errno . ") " . $this->conn->connect_error;
        }
    }

    public function getConn() {
        return $this->conn;
    }

    public function __destruct() {
        $this->conn->close();
    }

    public function execute() {
        $args = func_get_args();
        if ($args[0] === "insert") {
            $command = $this->conn->prepare('
                INSERT INTO events
                (start_datetime, end_datetime, name, location, description,
                facebook_link, instagram_link, twitter_link, misc_link)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $command->bind_param("sssssssss", $args[1], $args[2], $args[3],
                $args[4], $args[5], $args[6], $args[7], $args[8], $args[9]);
        } elseif ($args[0] === "update") {
            $command = $this->conn->prepare('
            UPDATE events set start_datetime=?, end_datetime=?, name=?,
            location=?, description=?, facebook_link=?, instagram_link=?,
            twitter_link=?, misc_link=?
            WHERE event_id=?');
            $command->bind_param("ssssssssss", $args[2], $args[3], $args[4],
                $args[5], $args[6], $args[7], $args[8], $args[9], $args[10],
                $args[1]);
        }
        if ($args[0] === "delete") {
            $command = $this->conn->prepare(
                'DELETE FROM events WHERE event_id = ?');
            $command->bind_param("i", $args[1]);
        }
        $command->execute();
        $result = $this->conn->query($command);
        return $result;
    }

    public function fetch (){
        $args = func_get_args();
        if ((count($args)) === 0) { //select all
            $command = $this->conn->prepare('SELECT * FROM events');
        } elseif(($args[0]) === "id") { //select individual id
            $command = $this->conn->prepare(
                'SELECT * FROM events WHERE event_id = ?');
            $command->bind_param("i", $args[1]);
        } elseif ($args[0] === "upcoming") {
            $command = $this->conn->prepare('
            SELECT * FROM events
            WHERE start_datetime >= NOW()
            ORDER BY start_datetime');
        } elseif ($args[0] === "passed") {
            $command = $this->conn->prepare('
            SELECT * FROM events
            WHERE start_datetime <= NOW()
            ORDER BY start_datetime');
        } elseif ($args[0] === "attends") {
            $command = $this->conn->prepare('
            SELECT * FROM attends AS a
            JOIN profiles AS b ON a.profile_id = b.profile_id
            WHERE a.event_id = ?');
            $command->bind_param("s", $args[1]);
        }
        $command->execute();
        $result = $command->get_result();
        $rows = array();
        for ($i = 0; $i < $result->num_rows; $i++) {
            $rows[$i] = $result->fetch_assoc();
        }
        return $rows;
    }

}

?>
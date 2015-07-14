<?php
class Db {

    private $conn;

    public function __construct($servername, $username, $password, $db_name, $port) {
        $this->conn = new mysqli($servername, $username, $password, $db_name, $port);
        if ($this->conn->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->conn->connect_errno . ") " . $this->conn->connect_error;
        }
    }

    public function __destruct() {
        $this->conn->close();
    }

    public function execute($command) {
        $result = $this->conn->query($command);
        return $result;
    }

    public function fetch ($command){
        $result = $this->execute($command);
        $rows = array();
        for ($i = 0; $i < $result->num_rows; $i++) {
            $rows[$i] = $result->fetch_assoc();
        }
        return $rows;
    }
}
?>
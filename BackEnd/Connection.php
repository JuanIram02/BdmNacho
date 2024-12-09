<?php

class Database {
    private $server;
    private $database;
    private $username;
    private $password;
    private $connection;

    public function __construct($server, $database, $username, $password) {
        $this->server = $server;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect() {
        $this->connection = @mysqli_connect($this->server, $this->username, $this->password, $this->database);
        if (!$this->connection) {
            die('Connect Error: ' . mysqli_connect_errno());
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function close() {
        mysqli_close($this->connection);
    }
}
?>

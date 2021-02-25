<?php

namespace Repository;

class Database
{
    public $mysqli;

    const USERS_TABLE = "users";
    const HOSPITALS_TABLE = "hospitals";

    public function __construct() {
        $this->db_connect();
    }

    private function db_connect(){
        $this->mysqli = new \MySQLi($_ENV['host'], $_ENV['username'], $_ENV['password'], $_ENV['db']);

        return $this->mysqli;
    }

    public function executeQuery($query) {
        if (!$results = $this->mysqli->query($query)) {
            header("HTTP/1.0 400 Input data error!");
            die;
        }
    }

    public function getResults($query) {
        $results = $this->mysqli->query($query);

        return $this->parseResults($results);
    }

    public function parseResults($res) {
        return $res->fetch_all(MYSQLI_ASSOC);
    }
}
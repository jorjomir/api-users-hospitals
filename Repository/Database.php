<?php

namespace Repository;

class Database
{
    const  HOST     = "localhost"; // your host name
    const  USERNAME = "root";      // your user name
    const  PASSWORD = "";          // your password
    const  DB       = "credo";     // your database name

    public $mysqli;

    const USERS_TABLE = "users";
    const HOSPITALS_TABLE = "hospitals";

    public function __construct() {
        $this->db_connect();
    }

    private function db_connect(){
        $this->mysqli = new \MySQLi(self::HOST, self::USERNAME, self::PASSWORD, self::DB);

        return $this->mysqli;
    }

    public function executeQuery($query) {
        if (!$results = $this->mysqli->query($query)) {
            header("HTTP/1.0 400 Input data error!");
            echo $this->mysqli->error;
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
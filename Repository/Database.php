<?php

namespace Repository;

use PDO;

class Database
{
    public $conn;

    const USERS_TABLE = "users";
    const HOSPITALS_TABLE = "hospitals";

    public function __construct() {
        $this->db_connect();
    }

    private function db_connect(){
        // Get credentials
        $host = $_ENV['host'];
        $user = $_ENV['username'];
        $pass = $_ENV['password'];
        $db   = $_ENV['db'];

        try {
            $this->conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);

        } catch (PDOException $e) {
            die("Error, please try again later!");
        }

        return $this->conn;
    }

    public function executeQuery($query) {
        $this->checkConnection();

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }
    }

    public function getResults($query) {
        $this->checkConnection();

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute();

        } catch (PDOException $e) {
            return false;
        }


        return $this->parseResults($stmt);
    }

    public function parseResults($res) {
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function checkConnection() {
        if(!$this->conn) {
            $this->db_connect();
        }
    }
}
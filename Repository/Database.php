<?php

namespace Repository;

use PDO;

class Database
{
    public $conn;

    const CONNECT_OPTIONS_ARR = array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION);


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
            $this->conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass, self::CONNECT_OPTIONS_ARR);

        } catch (PDOException $e) {
            return false;
        }

        return $this->conn;
    }

    public function executeQuery($query, $params) {
        $this->checkConnection();

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

        } catch (PDOException $e) {
            return false;
        }
    }

    public function getResults($query, $params) {
        $this->checkConnection();

        try{
            $stmt = $this->conn->prepare($query);
            $stmt->execute($params);

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
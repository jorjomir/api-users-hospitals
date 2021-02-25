<?php


namespace Repository;

class UserRepository extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($id) {
        $query = "SELECT * FROM " . parent::USERS_TABLE . " WHERE id = :id";
        $params = [
            'id' => $id,
        ];

        return parent::getResults($query, $params);
    }

    public function getUserByEmail($email) {

        $query = "SELECT * FROM " . parent::USERS_TABLE . " WHERE email = :email";
        $params = [
            'email' => $email,
        ];

        return parent::getResults($query, $params);
    }


    public function createNewUser(\Model\User $user) {

        $query = "INSERT INTO " . parent::USERS_TABLE . " (email, first_name, last_name, type, workplace_id) 
                    VALUES (:email, :first_name, :last_name, :type, :workplace)";
        $params = [
            'email'      => $user->getEmail(),
            'first_name' => $user->getFirstName(),
            'last_name'  => $user->getLastName(),
            'type'       => $user->getType(),
            'workplace'  => $user->getWorkplaceId(),
        ];

        if(parent::executeQuery($query, $params) === false) {
            return false;
        } else {
            return true;
        }
    }

    public function updateUser(\Model\User $user) {

        $query = "UPDATE " . parent::USERS_TABLE . " SET email = :email, first_name = :first_name, 
            last_name = :last_name, type = :type, workplace_id = :workplace WHERE id = :id";

        $params = [
            'email'      => $user->getEmail(),
            'first_name' => $user->getFirstName(),
            'last_name'  => $user->getLastName(),
            'type'       => $user->getType(),
            'workplace'  => $user->getWorkplaceId(),
            'id'         => $user->getId(),
        ];

        if(parent::executeQuery($query, $params) === false) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteUser($user_id) {
        $query = "DELETE FROM " . parent::USERS_TABLE . " WHERE id = :id";

        $params = [
            'id' => $user_id,
        ];

        if(parent::executeQuery($query, $params) === false) {
            return false;
        } else {
            return true;
        }
    }

    public function searchByWorkplaceId($workplace_id) {

        $query = "SELECT * FROM " . parent::USERS_TABLE . " WHERE workplace_id = :id";

        $params = [
            'id' => $workplace_id,
        ];

        return parent::getResults($query, $params);
    }

    public function searchByWorkplaceTitle($title) {

        $query = "SELECT usr.* FROM " . parent::USERS_TABLE . " usr JOIN " . parent::HOSPITALS_TABLE .
            " hosp ON usr.workplace_id=hosp.id WHERE hosp.name LIKE :title";

        $params = [
            'title' => "%" . $title . "%",
        ];

        return parent::getResults($query, $params);
    }

    public function searchByName($name) {

        $query = "SELECT * FROM " . parent::USERS_TABLE . " WHERE first_name 
            LIKE :name OR last_name LIKE :name";
        $params = [
            'name' => "%" . $name. "%",
        ];

        return parent::getResults($query, $params);
    }

    public function findAll() {

        $query = "SELECT * FROM " . parent::USERS_TABLE;

        return parent::getResults($query, []);
    }

    public function findAllOrdered($column, $type) {

        // $column and $type inputs are validated in the controller
        $query = "SELECT * FROM " . parent::USERS_TABLE . " ORDER BY " . $column . " " . $type;

        return parent::getResults($query, []);
    }

}
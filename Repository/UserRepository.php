<?php


namespace Repository;

class UserRepository extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getUser($id) {
        $query = sprintf(
            "SELECT * FROM %s WHERE id=%s",
            parent::USERS_TABLE, $id);

        return parent::getResults($query);
    }

    public function getUserByEmail($email) {
        $query = sprintf(
            "SELECT * FROM %s WHERE email='%s'",
            parent::USERS_TABLE, $email);

        return parent::getResults($query);
    }


    public function createNewUser(\Model\User $user) {

        $query = sprintf(
            "INSERT INTO %s (email, first_name, last_name, type, workplace_id) 
                    VALUES ('%s', '%s', '%s', %s, %s)",
            parent::USERS_TABLE, $user->getEmail(), $user->getFirstName(), $user->getLastName(),
            $user->getType(), $user->getWorkplaceId());

        parent::executeQuery($query);
    }

    public function updateUser(\Model\User $user) {
        $query = sprintf(
            "UPDATE %s SET email = '%s', first_name = '%s', last_name = '%s', type = %s, workplace_id = %s
                    WHERE id=%s",
            parent::USERS_TABLE, $user->getEmail(), $user->getFirstName(), $user->getLastName(),
            $user->getType(), $user->getWorkplaceId(), $user->getId());

        parent::executeQuery($query);
    }

    public function deleteUser($user_id) {
        $query = sprintf(
            "DELETE FROM %s WHERE id=%s",
            parent::USERS_TABLE, $user_id);

        parent::executeQuery($query);
    }

    public function searchByWorkplaceId($workplace_id) {
        $query = sprintf(
            "SELECT * FROM %s WHERE workplace_id=%s",
            parent::USERS_TABLE, $workplace_id);

        return parent::getResults($query);
    }

    public function searchByWorkplaceTitle($title) {

        // get constants as variables so we can concatenate them into the query
        $users_table = parent::USERS_TABLE;
        $hospitals_table = parent::HOSPITALS_TABLE;

        $query = "SELECT usr.* FROM $users_table usr JOIN $hospitals_table hosp 
                    ON usr.workplace_id=hosp.id WHERE hosp.name LIKE '%$title%'";

        return parent::getResults($query);
    }

    public function searchByName($name) {
        $users_table = parent::USERS_TABLE;

        $query = "SELECT * FROM $users_table WHERE first_name LIKE '%$name%' OR last_name LIKE '%$name%'";

        return parent::getResults($query);
    }

    public function findAll() {
        $query = sprintf(
            "SELECT * FROM %s", parent::USERS_TABLE);

        return parent::getResults($query);
    }

    public function findAllOrdered($column, $type) {
        $query = sprintf(
            "SELECT * FROM %s ORDER BY %s %s",
            parent::USERS_TABLE, $column, $type);

        return parent::getResults($query);
    }

}
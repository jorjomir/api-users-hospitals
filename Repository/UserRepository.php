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
            "UPDATE %s SET email = '%s', first_name = '%s', last_name = '%s', type = '%s', workplace_id = '%s'
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

    public function findAll() {
        $query = sprintf(
            "SELECT * FROM %s", parent::USERS_TABLE);

        return parent::getResults($query);
    }


}
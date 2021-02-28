<?php


namespace Repository;

use Model\User;

class HospitalRepository extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getHospital($id) {
        $query = "SELECT * FROM " . parent::HOSPITALS_TABLE . " WHERE id = :id";
        $params = [
            'id' => $id,
        ];

        return parent::getResults($query, $params);
    }

    public function createNewHospital(\Model\Hospital $hospital) {
        $query = "INSERT INTO " . parent::HOSPITALS_TABLE . " (name, address, phone) 
                    VALUES (:name, :address, :phone)";
        $params = [
            'name'    => $hospital->getName(),
            'address' => $hospital->getAddress(),
            'phone'   => $hospital->getPhone()
        ];

        if(parent::executeQuery($query, $params) == false) {
            return false;
        } else {
            return true;
        }
    }

    public function updateHospital(\Model\Hospital $hospital) {
        $query = sprintf(
            "UPDATE %s SET name = '%s', address = '%s', phone = '%s' WHERE id=%s",
            parent::HOSPITALS_TABLE, $hospital->getName(), $hospital->getAddress(), $hospital->getPhone(),
            $hospital->getId());

        if(parent::executeQuery($query) == false) {
            return false;
        } else {
            return true;
        }
    }

    public function deleteHospitalAndSaveUsers($hospital_id) {
        $query = "UPDATE " . parent::USERS_TABLE . " SET workplace_id=NULL, type = :type WHERE workplace_id = :id";
        $params = [
            'type' => User::PATIENT_TYPE,
            'id'   => $hospital_id
        ];

        if(parent::executeQuery($query, $params) === false) {
            return false;
        } else {
            return true;
        }

        $this->deleteHospital($hospital_id);
    }

    public function deleteHospitalAndDeleteUsers($hospital_id) {
        $delete_users_query = "DELETE FROM " . parent::USERS_TABLE . " WHERE workplace_id = :id";

        $params = [
            'id' => $hospital_id
        ];

        if(parent::executeQuery($delete_users_query, $params) == false) {
            return false;
        }

        return $this->deleteHospital($hospital_id);
    }

    public function deleteHospital($hospital_id) {
        $query = "DELETE FROM " . parent::HOSPITALS_TABLE . " WHERE id = :id";
        $params = [
            'id' => $hospital_id
        ];

        if(parent::executeQuery($query, $params) == false) {
            return false;
        } else {
            return true;
        }
    }

    public function findAll() {
        $query = "SELECT * FROM " . parent::HOSPITALS_TABLE;

        return parent::getResults($query, []);
    }

    public function findAllOrderedByEmployeeCount($order) {
        $query = "SELECT " . parent::HOSPITALS_TABLE . ".*, count(" . parent::USERS_TABLE . ".workplace_id) as employees_count 
                    FROM " . parent::HOSPITALS_TABLE . " 
                    LEFT JOIN " . parent::USERS_TABLE . " ON (" . parent::HOSPITALS_TABLE . ".id = " . parent::USERS_TABLE . ".workplace_id)
                    GROUP BY " . parent::HOSPITALS_TABLE . ".id
                    ORDER BY employees_count " . $order;

        return parent::getResults($query, []);
    }


}
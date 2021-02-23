<?php


namespace Repository;

class HospitalRepository extends Database
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getHospital($id) {
        $query = sprintf(
            "SELECT * FROM %s WHERE id=%s",
            parent::HOSPITALS_TABLE, $id);

        return parent::getResults($query);
    }

    public function createNewHospital(\Model\Hospital $hospital) {

        $query = sprintf(
            "INSERT INTO %s (name, address, phone) 
                    VALUES ('%s', '%s', '%s')",
            parent::HOSPITALS_TABLE, $hospital->getName(), $hospital->getAddress(), $hospital->getPhone());

        parent::executeQuery($query);
    }

    public function updateHospital(\Model\Hospital $hospital) {
        $query = sprintf(
            "UPDATE %s SET name = '%s', address = '%s', phone = '%s' WHERE id=%s",
            parent::HOSPITALS_TABLE, $hospital->getName(), $hospital->getAddress(), $hospital->getPhone(),
            $hospital->getId());

        parent::executeQuery($query);
    }

    public function findAll() {
        $query = sprintf(
            "SELECT * FROM %s", parent::HOSPITALS_TABLE);

        return parent::getResults($query);
    }


}
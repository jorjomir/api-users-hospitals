<?php

namespace Controller;

use Controller\RouteController;
use Model\Hospital;
use Model\User;

class HospitalController
{
    public function getHospitalData() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();

        if(!isset($data['id'])) {
            $route_controller->returnError(400, "No ID provided!");
        }
        $repo = new \Repository\HospitalRepository();

        $res = $repo->getHospital($data['id']);
        if(count($res) == 0) {
            $route_controller->returnError(400, "No hospital with this ID was found!");
        }

        $hospital = new \Model\Hospital();
        $hospital->setAllData($res[0]);

        $route_controller->response($hospital->toArray());
    }

    public function createNewHospital() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();

        if(!$this->allKeysExist(Hospital::MANDATORY_HOSPITAL_COLUMNS, $data)) {
            $route_controller->returnError(400, "All hospital keys must be included!");
        }
        $hospital = new \Model\Hospital();
        $hospital->setAllData($data);

        $repository = new \Repository\HospitalRepository();
        if($repository->createNewHospital($hospital) == false ) {
            $route_controller->returnError(500, "Server error");
        }

        $route_controller->blankResponse();
    }

    public function updateHospital() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();

        if(!isset($data['id'])) {
            $route_controller->returnError(400, "Input must contain hospital's ID!");
        }
        $requested_hospital = new \Model\Hospital();
        $requested_hospital->setAllData($data);

        $repo = new \Repository\HospitalRepository();
        $existing_record = $repo->getHospital($requested_hospital->getId());

        if( count($existing_record) == 0 ) {
            $route_controller->returnError(404, "There's no existing hospital with this ID!");
        }

        if($repo->updateHospital($requested_hospital) == false) {
            $route_controller->returnError(500, "Server error");
        }

        $route_controller->blankResponse();
    }

    public function deleteHospital() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();

        if(!isset($data['id'])) {
            $route_controller->returnError(400, "No ID provided!");
        }
        $delete_method = '';

        if(isset($data['associated_users_method'])) {

            if($data['associated_users_method'] == Hospital::EMPLOYEES_METHOD_DELETE) {
                $delete_method = Hospital::EMPLOYEES_METHOD_DELETE;

            } elseif ($data['associated_users_method'] == Hospital::EMPLOYEES_METHOD_SAVE) {
                $delete_method = Hospital::EMPLOYEES_METHOD_SAVE;

            } else {
                $route_controller->returnError(400, "Associated users method is not valid!");
            }
        } else {
            $route_controller->returnError(400, "Associated users method not provided!");
        }

        $repo = new \Repository\HospitalRepository();

        $hospital = $repo->getHospital($data['id']);
        if(count($hospital) == 0) {
            $route_controller->returnError(400, "No hospital with this ID was found!");
        }

        if($delete_method == Hospital::EMPLOYEES_METHOD_DELETE) {
            if($repo->deleteHospitalAndDeleteUsers($data['id']) == false) {
                $route_controller->returnError(500, "Server error");
            }
        } else {
            if($repo->deleteHospitalAndSaveUsers($data['id'])) {
                $route_controller->returnError(500, "Server error");
            }
        }

        $route_controller->blankResponse();
    }

    public function getAllHospitals() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();
        $repo = new \Repository\HospitalRepository();

        if(isset($data['users_count_order'])) {
            $this->getAllHospitalsOrderedByEmployee($data['users_count_order']);
            return;
        }

        $hospitals = $repo->findAll();
        if($hospitals == false) {
            $route_controller->returnError(500, "Server error");
        }

        $route_controller->response($hospitals);
    }

    public function getAllHospitalsOrderedByEmployee($order) {
        $route_controller = new RouteController();

        $order = strtoupper($order);
        if($order != "ASC" && $order != "DESC") {
            $route_controller->returnError(400, "Invalid order provided!");
        }

        $repo = new \Repository\HospitalRepository();
        $hospitals = $repo->findAllOrderedByEmployeeCount($order);
        if($hospitals == false) {
            $route_controller->returnError(500, "Server error");
        }
        $route_controller->response($hospitals);
    }

    function allKeysExist(array $keys, array $arr) {
        return !array_diff_key(array_flip($keys), $arr);
    }

}


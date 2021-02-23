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
        $repository->createNewHospital($hospital);

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
            $route_controller->returnError(400, "There's no existing hospital with this ID!");
        }

        $repo->updateHospital($requested_hospital);

        $route_controller->blankResponse();
    }

    public function deleteUser() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();

        if(!isset($data['id'])) {
            $route_controller->returnError(400, "No ID provided!");
        }
        $repo = new \Repository\UserRepository();

        $user = $repo->getUser($data['id']);
        if(count($user) == 0) {
            $route_controller->returnError(400, "No user with this ID was found!");
        }
        $repo->deleteUser($data['id']);

        $route_controller->blankResponse();
    }

    public function getAllHospitals() {
        $route_controller = new RouteController();
        $repo = new \Repository\HospitalRepository();

        $hospitals = $repo->findAll();

        $route_controller->response($hospitals);
    }

    function allKeysExist(array $keys, array $arr) {
        return !array_diff_key(array_flip($keys), $arr);
    }

}


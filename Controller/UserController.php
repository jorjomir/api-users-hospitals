<?php

namespace Controller;

use Controller\RouteController;
use Model\User;

class UserController
{
    public function getUserData() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();

        if(!isset($data['id'])) {
            $route_controller->returnError(400, "No ID provided!");
        }
        $repo = new \Repository\UserRepository();

        $res = $repo->getUser($data['id']);
        if(count($res) == 0) {
            $route_controller->returnError(404, "No user with this ID was found!");
        }

        $user = new \Model\User();
        $user->setAllData($res[0]);

        $route_controller->response($user->toArray());
    }

    public function createNewUser() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();

        if(!$this->allKeysExist(User::MANDATORY_USER_COLUMNS, $data)) {
            $route_controller->returnError(400, "All user keys must be included!");
        }
        $repository = new \Repository\UserRepository();

        if( count( $repository->getUserByEmail($data['email']) ) > 0 ) {
            $route_controller->returnError(400, "User with this email already exists!");
        }
        $user = new \Model\User();
        $user->setAllData($data);

        if($user->getType() == User::PATIENT_TYPE) {
            $user->setWorkplaceId(NULL);
        }

        if($repository->createNewUser($user) === false) {
            $route_controller->returnError(500, "Server error");
        }

        $route_controller->blankResponse();
    }

    public function updateUser() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();

        if(!isset($data['id'])) {
            $route_controller->returnError(400, "Input must contain user's ID!");
        }
        $input_user = new \Model\User();
        $input_user->setAllData($data);

        $repo = new \Repository\UserRepository();
        $existing_user = $repo->getUser($input_user->getId());

        if( count($existing_user) == 0 ) {
            $route_controller->returnError(404, "There's no existing user with this ID!");
        }

        if($input_user->getType() == User::PATIENT_TYPE) {
            $input_user->setWorkplaceId(NULL);
        }

        if($repo->updateUser($input_user) === false) {
            $route_controller->returnError(500, "Server error");
        }

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
            $route_controller->returnError(404, "No user with this ID was found!");
        }
        
        if($repo->deleteUser($data['id']) === false) {
            $route_controller->returnError(500, "Server error");
        }

        $route_controller->blankResponse();
    }

    public function searchUsers() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();

        $repo = new \Repository\UserRepository();

        if(isset($data['workplace_id'])) {

            $users = $repo->searchByWorkplaceId($data['workplace_id']);
            if($users === false) {
                $route_controller->returnError(500, "Server error");
            }
            $route_controller->response($users);

            return;
        } elseif (isset($data['workplace_title'])) {

            $users = $repo->searchByWorkplaceTitle($data['workplace_title']);

            if($users === false) {
                $route_controller->returnError(500, "Server error");
            }
            $route_controller->response($users);

            return;
        } elseif (isset($data['user_name'])) {

            $users = $repo->searchByName($data['user_name']);

            if($users === false) {
                $route_controller->returnError(500, "Server error");
            }
            $route_controller->response($users);

            return;
        } else {
            $route_controller->returnError(400, "You must include search parameters!");
        }
    }

    public function getAllUsers() {
        $route_controller = new RouteController();
        $data = $route_controller->getPostData();

        if(isset($data['order_column'])) {
            $this->getAllUsersOrdered($data);

            return;
        }

        $repo = new \Repository\UserRepository();

        $users = $repo->findAll();

        if($users === false) {
            $route_controller->returnError(500, "Server error");
        }

        $route_controller->response($users);
    }

    public function getAllUsersOrdered($data) {
        $route_controller = new RouteController();

        $order = '';

        if(isset($data['order_type'])) {
            $order = strtoupper($data['order_type']);

            if($order != "ASC" && $order != "DESC") {
                $route_controller->returnError(400, "Invalid order type provided!");
            }
        } else {
            $order = 'ASC';
        }

        if(!in_array($data['order_column'], User::ALL_USER_COLUMNS)) {
            $route_controller->returnError(400, "Invalid order column provided!");
        }

        $repo = new \Repository\UserRepository();
        $users = $repo->findAllOrdered($data['order_column'], $order);

        if($users === false) {
            $route_controller->returnError(500, "Server error");
        }
        $route_controller->response($users);

    }

    function allKeysExist(array $keys, array $arr) {
        return !array_diff_key(array_flip($keys), $arr);
    }

}
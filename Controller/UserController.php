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
            $route_controller->returnError(400, "No user with this ID was found!");
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
        $user = new \Model\User();
        $user->setAllData($data);

        $repository = new \Repository\UserRepository();
        $repository->createNewUser($user);

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
            $route_controller->returnError(400, "There's no existing user with this ID!");
        }

        $repo->updateUser($input_user);

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

    function allKeysExist(array $keys, array $arr) {
        return !array_diff_key(array_flip($keys), $arr);
    }

}
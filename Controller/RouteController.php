<?php


namespace Controller;

class RouteController
{

    private $route;

    public function __construct($router=null)
    {
        $this->route = $router;
    }

    public function matchRoute() {
        $this->route->setNamespace('\Controller');

        /*
         * User routes
         */
        $this->route->get('/user',   'UserController@getUserData');
        $this->route->post('/create-user', 'UserController@createNewUser');
        $this->route->put('/update-user',  'UserController@updateUser');
        $this->route->delete('/delete-user',  'UserController@deleteUser');
        $this->route->get('/get-all-users',  'UserController@getAllUsers');

        /*
         * Hospital routes
         */
        $this->route->get('/hospital',  'HospitalController@getHospitalData');
        $this->route->post('/create-hospital', 'HospitalController@createNewHospital');
        $this->route->put('/update-hospital',  'HospitalController@updateHospital');
        $this->route->delete('/delete-hospital',  'HospitalController@deleteHospital');
        $this->route->get('/get-all-hospitals',  'HospitalController@getAllHospitals');

    }

    public function getPostData() {
        $data = array();
        parse_str(file_get_contents('php://input'), $data);

        return $data;
    }

    public function response($data) {
        echo json_encode($data);
    }

    public function blankResponse() {
        http_response_code(200);
    }

    public function returnError($code, $msg) {
        header("HTTP/1.0 " . $code . " " . $msg);
        die;
    }



}
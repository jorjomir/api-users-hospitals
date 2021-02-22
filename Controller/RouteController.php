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

        $this->route->get('/user',   'UserController@getUserData');   //get User by ID
        $this->route->post('/create-user', 'UserController@createNewUser'); //create new User
        $this->route->put('/update-user',  'UserController@updateUser');    //update User
        $this->route->delete('/delete-user',  'UserController@deleteUser');    //update User

        $this->route->get('/about', function() { echo 'fdsf'; });

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
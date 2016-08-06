<?php

/*
* Mirko Gueregat - 16/10/2015
*/

namespace StaElisa\Users;

class UsersController
{
    private $res, $model;
    
    public function __construct($model, $res)
    {
        $this->res = $res;
        $this->model = $model;
    }
    
    public function login()
    {
        $rut = $_POST['rut'];
        while (strlen($rut) < 13) {
            $rut = "0".$rut;
        }
        $result = $this->model->login($rut, $_POST['year']);
        if ($result != false) {
            while ($row = $this->model->fetchRow($result)) {
                $users[] = $row;
            }
            $this->res->send(true, 200, $users);
        } else {
            $this->res->send(false, 400);
        }
    }
}

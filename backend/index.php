<?php
/*
* Mirko Gueregat - 16/10/2015
* Enrutamiento a los controladores, solo funcionando para rutas http://path/controller/function/id
*/
namespace StaElisa;

use \StaElisa\Config;
use \StaElisa\Utils;

include_once("config/config.php");
require_once("/util/respond.php");

$uri = $_SERVER['REQUEST_URI'];

if (preg_match("@/api/@", $uri)) {
    
    $respond = new Utils\Respond();
    
    $exploded = explode('/', substr($uri, strpos($uri, "api") + 4));
    
    $name = $exploded[0];
    $name = ucwords(strtolower($name));
    
    $controllerClass = "\\StaElisa\\" . $name . "\\" . $name . "Controller";
    $modelClass = "\\StaElisa\\" . $name . "\\" . $name . "Model";
    
    try {
        include_once("controllers/" . $name . "Controller.php");
        include_once("models/" . $name . "Model.php");
        
        $controller = new $controllerClass(new $modelClass(), $respond);
        
        if (isset($exploded[1]) and is_numeric($exploded[1])) {
            if (isset($exploded[2])) {
                if ($exploded[2] != "add") {
                    $controller->$exploded[2]($exploded[1]);
                } else {
                    echo "Malformed URI";
                }
            } else {
                $method = $_SERVER['REQUEST_METHOD'];
                if ($method == "GET") {
                    $controller->get($exploded[1]);
                } elseif ($method == "PUT") {
                    $controller->edit($exploded[1]);
                } elseif ($method == "DELETE") {
                    $controller->remove($exploded[1]);
                } else {
                    echo "No method for the request";
                }

            }
        } elseif (isset($exploded[1]) and !is_numeric($exploded[1])) {
            $function = explode('?', $exploded[1])[0];
            $controller->$function();
        } else {
            if ($_SERVER['REQUEST_METHOD'] == "POST") {
                $controller->add();
            } else {
                $controller->index();
            }
        }
    } catch (Exception $e) {

    }
}

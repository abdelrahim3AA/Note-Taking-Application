<?php

namespace TODO\App\LIB;

class FrontController
{

    private $_controller = 'index';
    private $_action = 'default';
    private $_params = [];

    public const NOT_FOUND_ACTION = "NotFoundAction";
    public const NOT_FOUND_CONTROLLER = "TODO\App\CONTROLLERS\NotFoundController";
    public function __construct()
    {
        $this->_parseUrl();
    }
    private function _parseUrl()
    {

        $url = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = str_replace('todo_app_mvc/public/', '', strtolower($url));
        $url = trim($url, '/');
        $url = explode('/', $url, 3);

        if (isset($url[0]) && $url[0] != '') {
            $this->_controller = $url[0];
        }
        if (isset($url[1]) && $url[1] != '') {
            $this->_action = $url[1];
        }

        if (isset($url[2]) && $url[2] != '') {
            $this->_params = explode('/', $url[2]);
        }

    }

    public function _dispatch()
    {

        $controllerClassName = 'TODO\App\CONTROLLERS\\' . ucfirst($this->_controller) . "Controller";
        $actionName = $this->_action . "Action"; 
        if (!class_exists($controllerClassName)) { 
            $controllerClassName = self::NOT_FOUND_CONTROLLER; 
        }
        $controller = new $controllerClassName();
        if (!method_exists($controller, $actionName)) {
            $this->_action = $actionName = self::NOT_FOUND_ACTION;
        }
        $controller->setController($this->_controller);
        $controller->setAction($this->_action);
        $controller->setParams($this->_params);
        $controller->$actionName($this->_params);
    }
}

<?php
namespace TODO\App\Controllers;

class AbstructController
{
    public const NOT_FOUND_ACTION = 'notfoundAction';
    private $_controller ;
    private $_action ;
    protected $_params;

    protected $_data = [];
    public function setController($controllerName)
    {
        $this->_controller = $controllerName;
    }

    public function setAction($actionName)
    {
        $this->_action = $actionName;
    }

    public function setParams($params)
    {
        $this->_params = $params;
    }

    protected function _view($path = NULL, $_params = NULL)
    {
        if ($path != NULL) {
            require_once $path;
            // var_dump($path, $_params);
        }
        if ($this->_action == self::NOT_FOUND_ACTION) //// index => default
        {
            require_once VIEWS_PATH . 'notfound' . DS . 'notfound.view.php';
        } else {
            $view = VIEWS_PATH . $this->_controller . DS . $this->_action . '.view.php';
        //    var_dump($this->_action, $this->_params);die;
            //// index/default.view.php

            if (file_exists($view)) {
                extract($this->_data);
                require_once $view;
            } else {
                require_once VIEWS_PATH . 'notfound' . DS . 'noview.view.php';
            }
        }

    }
}

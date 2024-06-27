<?php

namespace TODO;
use TODO\App\LIB\frontController;


if(!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR); 
}

require_once '..' . DS . 'app' . DS . 'config.php'; 
// require_once '..' . DS . 'vendor' . DS . 'autoload.php'; /// call autoload by composer 
require_once APP_PATH . DS . 'lib' . DS . 'autoload.php';

$frontController = new frontController(); 
// print "<pre>";
$frontController->_dispatch(); 

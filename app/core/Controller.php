<?php

namespace app\core;

use app\core\View;

abstract class Controller
{
    protected $route;
    protected $view;

    public function __construct(array $route, array $params)
    {
        if (method_exists($this, $route['action'])) {
            $this->route = $route;
            $this->view  = new View($route);
            $action      = $route['action'];

            if (count($params) === 0) $this->$action();
            else $this->$action(...$params);
        }
        else {
            View::errorCode(404);
        }
    }
}
<?php

namespace MeDesign\core;

class Application
{
    public static $config;

    protected $controller;
    protected $action;

    public function __construct()
    {
    }

    public function run() : void 
    {
        $controls = Router::getControls();

        $this->controller = $controls['controller'];
        $this->action = $controls['action'];
        if ($controls['other'] === '') {
            $this->runController();
        } else {
            (new \MeDesign\controller\MainController)->action404();
        }
    }

    protected function runController() : void
    {
        $controller = $this->controller;
        $controller = "\\MeDesign\\controller\\" . ucfirst($controller) . "Controller"; 
        if (class_exists($controller)) {
            $this->runAction($controller);
        } else {
            (new \MeDesign\controller\MainController)->action404();
        }
    }

    protected function runAction(string $controllerName) : void
    {
        $controller = new $controllerName();

        $action = $this->action;
        $action = "action" . ucfirst($action);
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            (new \MeDesign\controller\MainController)->action404();
        }
    }
}

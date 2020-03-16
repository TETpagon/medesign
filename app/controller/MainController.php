<?php 

namespace MeDesign\controller;

class MainController extends \MeDesign\core\Controller
{
    public function actionIndex()
    {
        $this->render();
        exit();
    }

    public function action404() 
    {
        $this->render("404");
        exit();
    }

    public function action500() 
    {
        $this->render("500");
        exit();
    }
}

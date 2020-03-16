<?php 

namespace MeDesign\core;

class Controller
{
    protected function render(string $view = 'index', array $params = [])
    {
        $template = \MeDesign\core\Application::$config['view']['defaultTemplate'];

        $dir = str_replace('Controller', '', get_class($this));
        $dir = str_replace('MeDesign\\controller\\', '', $dir);
        $dir = lcfirst($dir);

        $pathToView = __DIR__ . '\\..\\view\\' . $dir . '\\' . $view . '.php';
        
        extract($params);


        ob_start();
        if (file_exists($pathToView)) {
            require $pathToView;
        } else {
            (new \MeDesign\controller\MainController())->action500();
        }
        $content = ob_get_clean();

        $pathToTemplate = __DIR__ . '\\..\\view\\layout\\' . $template . '.php';
        ob_start();
        if (file_exists($pathToTemplate)) {
            require $pathToTemplate;
        } else {
            (new \MeDesign\controller\MainController())->action500();
        }
        echo ob_get_clean();
    }
}

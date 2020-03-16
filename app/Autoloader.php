<?php

namespace MeDesign;

class Autoloader
{
    public static function register () : void 
    {
        spl_autoload_register(array(new self, 'loadClass'));
    }

    public function loadclass($class) : bool 
    {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
        // убираем пространство имен поставщика
        $class = substr($class, 8);
        $class = __DIR__ . $class . '.php';
        if ($this->requireFile($class)) {
            return $class;
        }

        return false;
    }

    protected function requireFile($class) : bool 
    {
        if (file_exists($class)) {
            require $class;
            return true;
        }

        return false;
    }
}

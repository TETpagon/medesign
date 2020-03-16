<?php

require __DIR__ . "\app\Autoloader.php";
// require __DIR__ . "\app\core\Router.php";
// $config = require __DIR__ . "\app\config\config.php";

\MeDesign\Autoloader::register();
\MeDesign\core\Application::$config = require __DIR__ . "\app\config\config.php";
(new \MeDesign\core\Application())->run();



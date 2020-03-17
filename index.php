<?php

require __DIR__ . "\app\Autoloader.php";

\MeDesign\Autoloader::register();
\MeDesign\core\Application::$config = require __DIR__ . "\app\config\config.php";
(new \MeDesign\core\Application())->run();



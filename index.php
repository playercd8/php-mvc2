<?php
define('_PHPMVC2', 1);
define('_AppPath', 'application');
define('__ROOT__', dirname(dirname(__FILE__)));

// load application config (error reporting etc.)
require _AppPath.'/config/config.php';

// load application class
require _AppPath.'/sys/application.php';
require _AppPath.'/sys/controller.php';

// start the application
$app = new Application();
$app->run();
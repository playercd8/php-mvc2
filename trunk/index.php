<?php
define('__ROOT__', dirname(dirname(__FILE__)));

// load application config (error reporting etc.)
require 'application/config/config.php';

// load application class
require 'application/sys/application.php';
require 'application/sys/controller.php';

// start the application
$app = new Application();
$app->run();
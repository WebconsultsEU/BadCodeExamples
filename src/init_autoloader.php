<?php
namespace CleanCode;
//use CleanCode\Autoloader\Autoloader;

define( 'ROOT_PATH', __DIR__."/");
define( 'TEST_PATH', __DIR__."/../../tests/phpunit");

require_once(__DIR__ . '/Autoloader/Autoloader.php');
$autoloader = new Autoloader\Autoloader('CleanCode', ROOT_PATH);
$autoloader->register();
$autoloaderTest = new Autoloader\Autoloader('CleanCode\Test', __DIR__);
$autoloaderTest->register();



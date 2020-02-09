<?php 
session_start();
require_once(__DIR__ . "/requirements.php");

$di = new DependancyInjector();
$di->set("config", new Config());
$di->set("database", new Database($di));
$di->set('hash', new Hash());
$di->set("errorhandler", new ErrorHandler());
$di->set("validator", new Validator($di));
$di->set("util", new Util($di));



require_once "constants.php";


?>
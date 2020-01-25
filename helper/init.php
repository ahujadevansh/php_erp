<?php 
session_start();
require_once(__DIR__ . "/requirements.php");

$di = new DependancyInjector();
$di->set("config", new Config());
$di->set("database", new Database());


?>
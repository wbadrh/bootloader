<?php

require __DIR__ . '/../vendor/autoload.php';

$services = new wbadrh\Boot\Loader(__DIR__ . '/../composer.json');

$router = $services->get('wbadrh\Boot\Router');

$router->run();

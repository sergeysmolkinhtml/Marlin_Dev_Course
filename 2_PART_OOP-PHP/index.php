<?php

include_once 'functions.php';

$routes = [
    '/2_PART_OOP-PHP/' => 'homepage.php',
    '/2_PART_OOP-PHP/about' => 'about.php'
];

$route = $_SERVER['REQUEST_URI'];

if (array_key_exists($route, $routes)){
    include_once $routes[$route]; exit();
} else {
    echo '404';
}




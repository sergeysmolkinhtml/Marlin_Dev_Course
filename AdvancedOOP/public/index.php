<?php
if( !session_id() ) {
    session_start();
}

require 'G:\OS\OSPanel\domains\marlin-course\vendor\autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/AdvancedOOP/public/', ['App\Controllers\HomeController','index']);
    //$r->addRoute('GET', '/AdvancedOOP/public/about', ['App\Controllers\HomeController','about']);
});

$containerBuilder = new \DI\ContainerBuilder();
$container = $containerBuilder->build();
// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        // ... 404 Not Found
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        d($container);
        $controller = new $handler[0];
        call_user_func([$controller,$handler[1]],$vars);
        break;
}

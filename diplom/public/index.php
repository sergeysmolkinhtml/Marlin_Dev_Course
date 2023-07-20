<?php


use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\UserService;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\ContainerBuilder;
use League\Plates\Engine;

require '../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\HomeController', 'index']); //home
    $r->addRoute('GET', '/users', ['App\Controllers\UsersController', 'index']); //users
    $r->addRoute('GET', '/register', ['AuthController', 'register']);
    $r->addRoute('POST', '/register', ['AuthController', 'processRegistration']);
    $r->addRoute('GET', '/login', ['AuthController', 'login']);
    $r->addRoute('POST', '/login', ['AuthController', 'processLogin']);
    $r->addRoute('GET', '/changePassword', ['App\Controllers\UsersController', 'changePassword']);// / changepassword
    $r->addRoute('GET', '/edituser', ['App\Controllers\UsersController', 'editUser']);// / changepassword
    $r->addRoute('GET', '/verifyemail', ['App\Controllers\AuthController', 'verifyEmail']);// /verifyemail

});

$containerBuilder = new ContainerBuilder();
$containerBuilder->useAutowiring(true);
$containerBuilder->useAttributes(true);
$containerBuilder->addDefinitions([
    PDO::class => function () {
        return new PDO('mysql:host=localhost;dbname=pack', 'root', '');
    },
    Engine::class => function () {
        return new Engine('../app/Views');
    },
    Auth::class => function () {
        return new Delight\Auth\Auth(new PDO('mysql:host=localhost;dbname=pack', 'root', ''));
    },
    UserRepository::class => function () {
        return new UserRepository(new QueryFactory('mysql'), new PDO('mysql:host=localhost;dbname=pack', 'root', ''));
    },
    AuthService::class => function () {
        return new AuthService(new Delight\Auth\Auth(new PDO('mysql:host=localhost;dbname=pack', 'root', '')));
    },

]);

$container = $containerBuilder->build();

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 'not found';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $container->call($routeInfo[1], $routeInfo[2]);

        break;
}

<?php




use App\Controllers\UsersController;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\UserService;
use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\Container;
use DI\ContainerBuilder;
use Intervention\Image\ImageManager;
use League\Plates\Engine;

require '../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\HomeController', 'index']); //home
    $r->addRoute('GET', '/users', ['App\Controllers\UsersController', 'index']); //users
    $r->addRoute('GET', '/register-page', ['App\Controllers\AuthController', 'registerForm']); // registerForm
    $r->addRoute(['GET', 'POST'],  '/register-process', ['App\Controllers\AuthController', 'registerProcess']); //registerProcess
    $r->addRoute('GET', '/login-page', ['App\Controllers\AuthController', 'loginForm']);
    $r->addRoute(['GET', 'POST'],  '/login-process', ['App\Controllers\AuthController', 'loginProcess']);
    $r->addRoute('GET', '/verifyemail', ['App\Controllers\AuthController', 'verifyEmail']);// /verifyemail
                            //  #TODO uri parameter "?id=1"
    $r->addRoute('GET', '/edit-page/id={id:\d+}', ['App\Controllers\UsersController', 'edit']);// /edit user
    $r->addRoute(['GET', 'POST'], '/edituser/id={id:\d+}', ['App\Controllers\UsersController', 'update']);// / update process

    $r->addRoute('GET', '/security/id={id:\d+}', ['App\Controllers\UsersController', 'securitySettings']);// / changeauth form
    $r->addRoute(['GET', 'POST'], '/change-auth/id={id:\d+}', ['App\Controllers\UsersController', 'changeAuthData']);// / changepassword

    $r->addRoute('GET', '/mediaform/id={id:\d+}', ['App\Controllers\UsersController', 'uploadAvatarform']);// / upload photo form
    $r->addRoute(['GET', 'POST'], '/media/id={id:\d+}', ['App\Controllers\UsersController', 'uploadAvatar']);// / upload photo form


    $r->addRoute('GET', '/status/id={id:\d+}', ['App\Controllers\UsersController', 'status']);// / changestatus form
    $r->addRoute(['GET', 'POST'], '/change-status/id={id:\d+}', ['App\Controllers\UsersController', 'changeStatus']);// / change status

    $r->addRoute(['GET', 'POST'], '/delete/id={id:\d+}', ['App\Controllers\UsersController', 'delete']);// / delete

    $r->addRoute(['GET', 'POST'], '/logout', ['App\Controllers\AuthController', 'logout']);// / delete

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
    Auth::class => function (Container $container) {
        return new Auth($container->get(PDO::class));
    },
    UserRepository::class => function (Container $container) {
        return new UserRepository(new QueryFactory('mysql'), $container->get(PDO::class));
    },
    UserService::class => function(Container $container) {
        return new UserService($container->get(UserRepository::class),$container->get(ImageManager::class));
    },
    AuthService::class => function (Container $container) {
        return new AuthService($container->get(Auth::class));
    },

    UsersController::class => function (Container $container) {
        return new UsersController(
            $container->get(Engine::class),
            $container->get(AuthService::class),
            $container->get(UserService::class),
            $container->get(UserRepository::class)
        );
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
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo 'not allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $container->call($routeInfo[1], $routeInfo[2]);

        break;
}

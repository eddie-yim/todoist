<?php
require_once 'vendor/autoload.php';

use Practice\Repository\Impl\EntityManagerProvider;
use Silex\Application;
use Silex\Provider\SessionServiceProvider;
use Silex\Provider\ServiceControllerServiceProvider;
use Practice\Repository\Impl\TodoRepositoryImpl;
use Practice\Repository\Impl\UserRepositoryImpl;
use Practice\Service\Impl\TodoServiceImpl;
use Practice\Service\Impl\UserServiceImpl;
use Practice\Web\Controller\MainController;
use Practice\Web\Controller\TodoController;
use Practice\Web\Controller\AccountController;



#entity manager
$entity_manager = EntityManagerProvider::getEntityManager();


#Silex Application
$app = new Application();

#session
$app->register(new SessionServiceProvider());

#for controllers
$app->register(new ServiceControllerServiceProvider());


#twig
$app->register(new Silex\Provider\TwigServiceProvider(), [
    'twig.path' => __DIR__.'/view'
]);


#repositories
$app['repository.todo'] = function() use ($app, $entity_manager) {
    return new TodoRepositoryImpl($entity_manager);
};

$app['repository.user'] = function() use ($app, $entity_manager) {
    return new UserRepositoryImpl($entity_manager);
};


#services
$app['service.todo'] = function() use ($app) {
    return new TodoServiceImpl($app['repository.todo']);
};

$app['service.user'] = function() use ($app) {
    return new UserServiceImpl($app['repository.user']);
};


#controllers
$app['controller.main'] = function() use ($app) {
    return new MainController($app['service.user']);
};

$app['controller.todo'] = function() use ($app) {
    return new TodoController($app['service.todo'], $app['service.user']);
};

$app['controller.account'] = function() use ($app) {
    return new AccountController($app['service.user']);
};

#mount
$app->mount('/', $app['controller.main']);

$app->mount('/todos', $app['controller.todo']);

$app->mount('/account', $app['controller.account']);

$app->run();

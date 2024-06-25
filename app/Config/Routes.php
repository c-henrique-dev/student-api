<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->group('user', ['filter' => 'authFilter'], function ($routes) {
    $routes->get('list', 'UserController::list');
});

$routes->group('student', ['filter' => 'authFilter'], function ($routes) {
    $routes->post('create', 'StudentController::create');
    $routes->get('list', 'StudentController::list');
    $routes->patch('update/(:num)', 'StudentController::update/$1');
    $routes->delete('delete/(:num)', 'StudentController::delete/$1');
});

$routes->group('lesson', ['filter' => 'authFilter'], function ($routes) {
    $routes->post('create', 'LessonController::create');
});

$routes->post('login', 'LoginController::index');
$routes->post('user/create', 'UserController::create');

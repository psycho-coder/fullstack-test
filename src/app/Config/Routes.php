<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::posts', ['as' => 'home']);

$routes->get('/post/(:num)', 'Home::post/$1', ['as' => 'post']);

$routes->post('/comment/add', 'Home::add', ['as' => 'add_comment']);

$routes->post('/comment/(:num)/remove', 'Home::remove/$1', ['as' => 'remove_comment']);
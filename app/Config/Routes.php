<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

$routes->get('admin/login', 'Admin\Auth::showLogin');
$routes->post('admin/login', 'Admin\Auth::login');
$routes->group('admin', ['filter' => 'adminAuth'], static function (RouteCollection $routes): void {
    $routes->get('/', 'Admin\Dashboard::index');
    $routes->post('logout', 'Admin\Auth::logout');
    $routes->get('profile', 'Admin\Profile::edit');
    $routes->post('profile', 'Admin\Profile::save');
    $routes->get('records/(:segment)', 'Admin\Records::index/$1');
    $routes->get('records/(:segment)/new', 'Admin\Records::newForm/$1');
    $routes->post('records/(:segment)/create', 'Admin\Records::create/$1');
    $routes->get('records/(:segment)/(:num)/edit', 'Admin\Records::edit/$1/$2');
    $routes->post('records/(:segment)/(:num)/update', 'Admin\Records::update/$1/$2');
    $routes->post('records/(:segment)/(:num)/delete', 'Admin\Records::delete/$1/$2');
});

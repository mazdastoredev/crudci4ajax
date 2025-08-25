<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Products::index');

$routes->group('products', static function ($routes) {
    $routes->get('/', 'Products::index');            // halaman utama
    $routes->get('list', 'Products::list');          // JSON list
    $routes->get('show/(:num)', 'Products::show/$1');

    $routes->post('store', 'Products::store');       // create
    $routes->post('update/(:num)', 'Products::update/$1'); // update (POST + _method OPSIONAL)
    $routes->post('delete/(:num)', 'Products::delete/$1'); // delete (POST)
});

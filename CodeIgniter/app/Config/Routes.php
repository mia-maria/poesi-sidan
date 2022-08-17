<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->match(['post'], 'user/registration', 'User::register');
$routes->match(['post'], 'user/login', 'User::authenticate');
$routes->match(['post'], 'user/delete', 'User::delete');
$routes->match(['post'], 'user/logout', 'User::logoutUser');

$routes->match(['post'], 'poems/create', 'Poems::create');
$routes->match(['post'], 'poems/update/(:num)', 'Poems::update/$1');
$routes->match(['post'], 'poems/delete/(:num)', 'Poems::delete/$1');

$routes->get('/', 'Pages::index');

$routes->get('/poems', 'Poems::index');
$routes->get('/poems/myPoems', 'Poems::myPoems');
$routes->get('/poems/new', 'Poems::new');
$routes->get('/poems/edit/(:num)', 'Poems::edit/$1');
$routes->get('/poems/remove/(:num)', 'Poems::remove/$1');
$routes->get('/poems/author/(:num)', 'Poems::showPoems/$1');

$routes->get('/user/registration', 'User::registration');
$routes->get('/user/login', 'User::login');
$routes->get('/user/info', 'User::info');
$routes->get('/user/logout', 'User::logout');
$routes->get('/user/logoutMessage', 'User::message');
$routes->get('/user/removeMember', 'User::remove');
$routes->get('/user/goodbyeMessage', 'User::goodbyeMessage');
/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

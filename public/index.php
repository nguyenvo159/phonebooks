<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once __DIR__ . '/../bootstrap.php';

define('APPNAME', 'My Phonebook');

session_start();

$router = new \Bramus\Router\Router();

// Auth routes
$router->post('/logout', '\App\Controllers\Auth\LoginController@destroy');
$router->get('/register', '\App\Controllers\Auth\RegisterController@create');
$router->post('/register', '\\App\Controllers\Auth\RegisterController@store');
$router->get('/login', '\App\Controllers\Auth\LoginController@create');
$router->post('/login', '\App\Controllers\Auth\LoginController@store');

// Contact routes
$router->get('/', '\App\Controllers\ContactsController@index');
$router->get('/home', '\App\Controllers\ContactsController@index');

$router->set404('\App\Controllers\Controller@sendNotFound');

$router->get('/contacts/create', '\App\Controllers\ContactsController@create');
$router->post('/contacts', '\App\Controllers\ContactsController@store');

$router->run();

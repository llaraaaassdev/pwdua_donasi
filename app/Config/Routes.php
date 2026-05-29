<?php

namespace Config;

use CodeIgniter\Config\Services;

$routes = Services::routes();

$routes->get('/', fn() => redirect()->to('/login'));

$routes->get('/login', 'Auth::login');
$routes->post('/login', 'Auth::process');

$routes->get('/register', 'Auth::register');
$routes->post('/register', 'Auth::processRegister');

$routes->get('/logout', 'Auth::logout');

$routes->get('/dashboard', 'Dashboard::index');
<?php

namespace Config;

use CodeIgniter\Config\Services;

$routes = Services::routes();


// Authentication

$routes->get('/login', 'AuthController::login');

$routes->post('/login', 'AuthController::loginProcess');

$routes->get('/register', 'AuthController::register');

$routes->post('/register', 'AuthController::registerProcess');

$routes->get('/register-yayasan', 'AuthController::registerYayasan');

$routes->post('/register-yayasan', 'AuthController::registerYayasanProcess');

$routes->get('/logout', 'AuthController::logout');


// ================
// ADMIN
// ================
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {
    $routes->get('dashboard', 'AdminController::index');
});

// ================
// yayasan
// ================
$routes->group('yayasan', ['filter' => 'role:yayasan'], function ($routes) {
    $routes->get('lengkapi-profil', 'FoundationController::create');
    $routes->post('lengkapi-profil', 'FoundationController::store');
    $routes->get('status', 'FoundationController::status'
);
});


// ================
// DONATUR
// ================
$routes->group('donatur', ['filter' => 'role:donatur'], function ($routes) {
    $routes->get('dashboard', 'DonaturController::index');
});


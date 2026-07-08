<?php

namespace Config;

use CodeIgniter\Config\Services;

$routes = Services::routes();

// =====================
// PUBLIC WEBSITE
// =====================

$routes->get('/', 'HomeController::index');
$routes->get('/campaign/(:num)', 'HomeController::detail/$1');
$routes->get('/berita-donasi', 'HomeController::beritaDonasi');
$routes->get('/laporan', 'HomeController::laporan');
$routes->get('/laporan/(:num)', 'HomeController::detailLaporan/$1');
$routes->post('/laporan/(:num)/komentar', 'HomeController::storeReportComment/$1');

$routes->get('payment/checkout/(:num)', 'PaymentController::checkout/$1');
$routes->post('payment/notification', 'PaymentController::notification');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginProcess');

$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::registerProcess');

$routes->get('register-yayasan', 'AuthController::registerYayasan');
$routes->post('register-yayasan', 'AuthController::registerYayasanProcess');

$routes->get('logout', 'AuthController::logout');

/*
|--------------------------------------------------------------------------
| NOTIFIKASI
|--------------------------------------------------------------------------
*/
$routes->group('notifications', ['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'NotificationController::index');
});


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
| Hanya dapat diakses oleh role admin
|--------------------------------------------------------------------------
*/

$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {

    /*
    |----------------------------------------------------------
    | Dashboard Admin
    |----------------------------------------------------------
    */
    $routes->get('dashboard', 'AdminController::index');

    /*
    |----------------------------------------------------------
    | Manajemen Yayasan
    |----------------------------------------------------------
    */
    $routes->get('yayasan', 'FoundationController::index');
    $routes->get('yayasan/detail/(:num)', 'FoundationController::detail/$1');
    $routes->get('yayasan/approve/(:num)', 'FoundationController::approve/$1');
    $routes->get('yayasan/reject/(:num)', 'FoundationController::reject/$1');
    $routes->get('yayasan/delete/(:num)', 'FoundationController::delete/$1');

    /*
    |----------------------------------------------------------
    | Manajemen Campaign
    |----------------------------------------------------------
    */
    $routes->get('campaign', 'CampaignController::index');
    $routes->get('campaign/detail/(:num)', 'CampaignController::detail/$1');
    $routes->get('campaign/create', 'CampaignController::create');
    $routes->post('campaign/store', 'CampaignController::store');
    $routes->get('campaign/edit/(:num)', 'CampaignController::edit/$1');
    $routes->post('campaign/update/(:num)', 'CampaignController::update/$1');
    $routes->get('campaign/delete/(:num)', 'CampaignController::delete/$1');
    $routes->post('campaign/delete/(:num)', 'CampaignController::delete/$1');
    // Dibuat GET dan POST supaya tombol/link approve/reject/delete lama maupun form baru tetap berjalan.
    $routes->get('campaign/approve/(:num)', 'CampaignController::approve/$1');
    $routes->post('campaign/approve/(:num)', 'CampaignController::approve/$1');
    $routes->get('campaign/reject/(:num)', 'CampaignController::reject/$1');
    $routes->post('campaign/reject/(:num)', 'CampaignController::reject/$1');

    /*
    |----------------------------------------------------------
    | Manajemen Kategori Donasi
    |----------------------------------------------------------
    */
    $routes->get('category', 'CategoryController::index');
    $routes->get('category/create', 'CategoryController::create');
    $routes->post('category/store', 'CategoryController::store');
    $routes->get('category/edit/(:num)', 'CategoryController::edit/$1');
    $routes->post('category/update/(:num)', 'CategoryController::update/$1');
    $routes->post('category/delete/(:num)', 'CategoryController::delete/$1');
    $routes->get('category/delete/(:num)', 'CategoryController::delete/$1');

    /*
    |----------------------------------------------------------
    | Manajemen User
    |----------------------------------------------------------
    */
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/detail/(:num)', 'Admin\UserController::detail/$1');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');

    /*
    |----------------------------------------------------------
    | Manajemen Donation
    |----------------------------------------------------------
    */
    $routes->get('donation', 'DonationController::index');
    $routes->get('donations', 'DonationController::index');
    $routes->get('donation/detail/(:num)', 'DonationController::detail/$1');
    $routes->get('donation/verify/(:num)', 'DonationController::verify/$1');
    $routes->post('donation/verify/(:num)', 'DonationController::verify/$1');
    $routes->get('donation/reject/(:num)', 'DonationController::reject/$1');
    $routes->post('donation/reject/(:num)', 'DonationController::reject/$1');

    /*
    |----------------------------------------------------------
    | Verifikasi Laporan Penggunaan Dana
    |----------------------------------------------------------
    */
    $routes->get('report', 'FoundationController::adminReports');
    $routes->get('report/detail/(:num)', 'FoundationController::adminReportDetail/$1');
    $routes->post('report/approve/(:num)', 'FoundationController::approveReport/$1');
    $routes->post('report/reject/(:num)', 'FoundationController::rejectReport/$1');
});

/*
|--------------------------------------------------------------------------
| YAYASAN
|--------------------------------------------------------------------------
| Hanya dapat diakses oleh role yayasan
|--------------------------------------------------------------------------
*/

$routes->group('yayasan', ['filter' => 'role:yayasan'], function ($routes) {

    /*
    |----------------------------------------------------------
    | Dashboard Yayasan
    |----------------------------------------------------------
    */
    $routes->get('dashboard', 'FoundationController::dashboard');

    /*
    |----------------------------------------------------------
    | CRUD Profil Yayasan Sendiri
    |----------------------------------------------------------
    |
    | CREATE  : profile/store
    | READ    : profile
    | UPDATE  : profile/update
    | DELETE  : profile/delete
    |
    */
    $routes->get('profile', 'FoundationController::profile');
    $routes->post('profile/store', 'FoundationController::store');
    $routes->post('profile/update', 'FoundationController::updateProfile');
    $routes->post('profile/delete', 'FoundationController::deleteProfile');

    /*
    |----------------------------------------------------------
    | Status Verifikasi Yayasan
    |----------------------------------------------------------
    */
    $routes->get('status', 'FoundationController::status');

    /*
    |----------------------------------------------------------
    | Campaign Milik Yayasan
    |----------------------------------------------------------
    */
    $routes->get('campaign/index', 'FoundationController::myCampaign');
    $routes->get('campaign/detail/(:num)', 'FoundationController::detailCampaign/$1');
    $routes->get('campaign/create', 'FoundationController::createCampaign');
    $routes->post('campaign/store', 'FoundationController::storeCampaign');
    $routes->get('campaign/edit/(:num)', 'FoundationController::editCampaign/$1');
    $routes->post('campaign/update/(:num)', 'FoundationController::updateCampaign/$1');
    $routes->get('campaign/delete/(:num)', 'FoundationController::deleteCampaign/$1');

    /*
    |----------------------------------------------------------
    | Donasi Masuk ke Campaign Yayasan
    |----------------------------------------------------------
    */
    $routes->get('donation/index', 'FoundationController::donations');

    /*
    |----------------------------------------------------------
    | Laporan Penggunaan Dana Yayasan
    |----------------------------------------------------------
    */
    $routes->get('report', 'FoundationController::reports');
    $routes->get('report/create', 'FoundationController::createReport');
    $routes->post('report/store', 'FoundationController::storeReport');
    $routes->get('report/detail/(:num)', 'FoundationController::detailReport/$1');
    $routes->get('report/edit/(:num)', 'FoundationController::editReport/$1');
    $routes->post('report/update/(:num)', 'FoundationController::updateReport/$1');
});

/*
|--------------------------------------------------------------------------
| DONATUR
|--------------------------------------------------------------------------
*/

$routes->group('donatur', ['filter' => 'role:donatur'], function ($routes) {

    /*
    |----------------------------------------------------------
    | Dashboard Donatur
    |----------------------------------------------------------
    */
    $routes->get('dashboard', 'DonaturController::dashboard');

    /*
    |----------------------------------------------------------
    | Campaign untuk Donatur
    |----------------------------------------------------------
    */
    $routes->get('campaign/index', 'DonaturController::campaign');
    $routes->get('campaign/(:num)', 'DonaturController::detailCampaign/$1');

    /*
    |----------------------------------------------------------
    | Donasi Donatur
    |----------------------------------------------------------
    */
    $routes->get('donation/create/(:num)', 'DonaturController::createDonation/$1');
    $routes->post('donation/store', 'DonaturController::storeDonation');
    $routes->get('donation/upload/(:num)', 'DonaturController::uploadBukti/$1');
    $routes->post('donation/upload/(:num)', 'DonaturController::saveBukti/$1');

    /*
    |----------------------------------------------------------
    | Riwayat Donasi
    |----------------------------------------------------------
    */
    $routes->get('history', 'DonaturController::history');
    $routes->get('history/(:num)', 'DonaturController::detailHistory/$1');
});
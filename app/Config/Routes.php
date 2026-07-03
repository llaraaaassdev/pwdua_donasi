<?php

namespace Config;

use App\Controllers\DonationController;
use CodeIgniter\Config\Services;

$routes = Services::routes();

// --------------------------------------------------------------------------
//  HALAMAN AWAL
// --------------------------------------------------------------------------
$routes->get('/', function () {
    return redirect()->to('/login');
});

// |--------------------------------------------------------------------------
// | AUTHENTICATION
// |--------------------------------------------------------------------------
$routes->get('login', 'AuthController::login');
$routes->post('login', 'AuthController::loginProcess');

$routes->get('register', 'AuthController::register');
$routes->post('register', 'AuthController::registerProcess');

$routes->get('register-yayasan', 'AuthController::registerYayasan');
$routes->post('register-yayasan', 'AuthController::registerYayasanProcess');

$routes->get('logout', 'AuthController::logout');


// |--------------------------------------------------------------------------
// | ADMIN
// |--------------------------------------------------------------------------
// | Hanya dapat diakses oleh role admin
$routes->group('admin', ['filter' => 'role:admin'], function ($routes) {

    // | Dashboard
    $routes->get('dashboard', 'AdminController::index');

    // |----------------------------------------------------------
    // | Manajemen Yayasan
    // |----------------------------------------------------------
    $routes->get('yayasan', 'FoundationController::index');
    $routes->get('yayasan/detail/(:num)', 'FoundationController::detail/$1');
    $routes->get('yayasan/approve/(:num)', 'FoundationController::approve/$1');
    $routes->get('yayasan/reject/(:num)', 'FoundationController::reject/$1');
    $routes->get('yayasan/delete/(:num)', 'FoundationController::delete/$1');
    
    // |----------------------------------------------------------
    // | Manajemen Campaign
    // |----------------------------------------------------------
    $routes->get('campaign', 'CampaignController::index');
    $routes->get('campaign/detail/(:num)', 'CampaignController::detail/$1');
    $routes->get('campaign/create', 'CampaignController::create');
    $routes->post('campaign/store', 'CampaignController::store');
    $routes->get('campaign/edit/(:num)', 'CampaignController::edit/$1');
    $routes->post('campaign/update/(:num)', 'CampaignController::update/$1');
    $routes->get('campaign/delete/(:num)', 'CampaignController::delete/$1');
    $routes->post('campaign/approve/(:num)', 'CampaignController::approve/$1');
    $routes->post('campaign/reject/(:num)', 'CampaignController::reject/$1');

    // |----------------------------------------------------------
    // | Manajemen User
    // |----------------------------------------------------------
    $routes->get('users', 'Admin\UserController::index');
    $routes->get('users/detail/(:num)', 'Admin\UserController::detail/$1');
    $routes->get('users/edit/(:num)', 'Admin\UserController::edit/$1');
    $routes->post('users/update/(:num)', 'Admin\UserController::update/$1');
    $routes->get('users/delete/(:num)', 'Admin\UserController::delete/$1');


    // --------------------------------------------------
    // MANAJEMEN DONATION
    // --------------------------------------------------
    $routes->get('admin/donation','DonationController::index');
    $routes->get('admin/donation/detail/(:num)','DonationController::detail/$1');
    $routes->get('admin/donation/verify/(:num)','DonationController::verify/$1');
    $routes->get('admin/donation/reject/(:num)','DonationController::reject/$1');

});



/*
|--------------------------------------------------------------------------
| YAYASAN
|--------------------------------------------------------------------------
| Hanya role yayasan
|
*/

$routes->group('yayasan', ['filter' => 'role:yayasan'], function ($routes) {
    $routes->get('dashboard','FoundationController::dashboard');
    $routes->get('campaign/index','FoundationController::myCampaign');
    $routes->get('campaign/detail/(:num)','FoundationController::detailCampaign/$1');
    $routes->get('campaign/create','FoundationController::createCampaign');
    $routes->post('campaign/store','FoundationController::storeCampaign');
    $routes->get('campaign/delete/(:num)','FoundationController::deleteCampaign/$1');
    $routes->get('campaign/edit/(:num)','FoundationController::editCampaign/$1');
    $routes->post('campaign/update/(:num)','FoundationController::updateCampaign/$1');

    $routes->get('donation/index','FoundationController::donations');
    /*
    |----------------------------------------------------------
    | Profil Yayasan
    |----------------------------------------------------------
    */

    $routes->get('profile', 'FoundationController::create');
    $routes->post('profile/store', 'FoundationController::store');

    // status verifikasi yayasan
    $routes->get('status', 'FoundationController::status');



    /*
    |----------------------------------------------------------
    | Campaign
    |----------------------------------------------------------
    */

    // daftar campaign
    $routes->get('campaign', 'CampaignController::index');

    // tambah campaign
    $routes->get('campaign/create', 'CampaignController::create');
    $routes->post('campaign/store', 'CampaignController::store');

    // detail campaign
    $routes->get('campaign/detail/(:num)', 'CampaignController::detail/$1');

    // edit campaign
    $routes->get('campaign/edit/(:num)', 'CampaignController::edit/$1');
    $routes->post('campaign/update/(:num)', 'CampaignController::update/$1');

    // hapus campaign
    $routes->get('campaign/delete/(:num)', 'CampaignController::delete/$1');

});



/*
|--------------------------------------------------------------------------
| DONATUR
|--------------------------------------------------------------------------
*/

$routes->group('donatur', ['filter' => 'role:donatur'], function ($routes) {

    // dashboard donatur
    $routes->get('dashboard', 'DonaturController::dashboard');
    $routes->get('campaign/index', 'DonaturController::campaign');
    $routes->get('campaign/(:num)', 'DonaturController::detailCampaign/$1');
    $routes->get('campaign/(:num)','DonaturController::detailCampaign/$1');
    $routes->get('donation/create/(:num)','DonaturController::createDonation/$1');
    $routes->post('donation/store','DonaturController::storeDonation');
    $routes->get('donation/upload/(:num)','DonaturController::uploadBukti/$1');
    $routes->post('donation/upload/(:num)','DonaturController::saveBukti/$1');
    $routes->get('history','DonaturController::history');
    $routes->get('history/(:num)','DonaturController::detailHistory/$1');

});
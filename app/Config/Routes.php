<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('TestDB', 'TestDB::index');

$routes->get('/', 'Frontend\Home::index');
$routes->get('form-intro', 'Frontend\Form::index');
$routes->get('form', 'Frontend\Form::form');

$routes->get('home-appliances', 'Frontend\Form::homeAppliances');
$routes->get('group-buying', 'Frontend\Form::groupBuying');

$routes->get('home-appliances-form', 'Frontend\Form::homeAppliancesForm');
$routes->get('group-buying-form', 'Frontend\Form::groupBuyingForm');
$routes->get('send-success', 'Frontend\Form::sendSuccess');

$routes->post('submit-form', 'Frontend\Form::submitForm');




$routes->group('yuanadmin', ['namespace' => 'App\Controllers\Backend'], function($routes) {
    $routes->get('/', 'Login::index');
    $routes->post('getLogin', 'Login::getLogin');
    $routes->get('logout', 'Login::logout');
    
    $routes->get('dashboard', 'Dashboard::index');

    $routes->addRedirect('form-datatable', 'yuanadmin/form-datatable/home-appliances');
    
    $routes->get('form-datatable/(:any)', 'Form::index/$1');
    $routes->post('getFormData', 'Form::getFormData');
    $routes->post('updateStatus', 'Form::updateStatus');
    $routes->get('sendFilter', 'Form::sendFilter');
    $routes->get('export-csv/(:any)', 'Form::exportCsv/$1');

    $routes->get('api/form-datatable/(:any)', 'Form::apiDatatable/$1');
});
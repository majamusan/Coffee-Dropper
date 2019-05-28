<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$router->get('/GetLogs/', 'LocationsController@GetLogs')->name('GetLogs');
$router->get('/GetNearestLocation/', 'LocationsController@GetNearestLocation')->name('GetNearestLocation');
$router->post('/CreateNewLocation/', 'LocationsController@CreateNewLocation')->name('CreateNewLocation');
$router->post('/CalculateCashback/', 'LocationsController@CalculateCashback')->name('CalculateCashback');
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('dashboard.index');
})->name('dashboard');
Route::resource('roles', 'RolesController');
Route::resource('prices', 'PricesController');
Route::post('prices/status', 'PricesController@status')->name('prices.status');
Route::resource('pays', 'PaysController');
Route::post('pays/status', 'PaysController@status')->name('pays.status');
Route::resource('users', 'UsersController');
Route::post('users/status', 'UsersController@status')->name('users.status');
Route::resource('detail-shippers', 'DetailShipperController');
Route::post('detail-shippers/detail', 'DetailShipperController@detail')->name('detail-shippers.detail');
Route::get('provinces', 'ProvinceController@index')->name('provinces.index');
Route::get('districts', 'DistrictController@index')->name('districts.index');
Route::get('wards', 'WardController@index')->name('wards.index');

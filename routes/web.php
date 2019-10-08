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
Route::get('/users', function () {
    return view('users.index');
});
Route::resource('roles', 'RolesController');
Route::resource('prices', 'PricesController');
Route::post('prices/status', 'PricesController@status')->name('prices.status');
Route::resource('pays', 'PaysController');
Route::post('pays/status', 'PaysController@status')->name('pays.status');

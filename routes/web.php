<?php

Route::get('/panel', function () {
    return view('dashboard.index');
})->name('dashboard');
Route::get('/tables', '__@getTables');
Route::get('/', 'PortalController@index')->name('portal.index');
Route::post('portal/assign', 'PortalController@assign')->name('portal.assign');
Route::get('portal/shippers', 'PortalController@get_shippers')->name('portal.shippers');
Route::post('portal/status', 'PortalController@update_status')->name('portal.status');
Route::post('portal/transfers', 'PortalController@transfers')->name('portal.transfers');
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
Route::resource('orders', 'OrdersController');
Route::post('orders/code', 'OrdersController@code')->name('orders.code');
Route::resource('units', 'UnitsController');

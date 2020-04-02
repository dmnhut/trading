<?php
Route::get('/panel', function () {
    return view('dashboard.index');
})->name('dashboard')->middleware('auth');
Route::get('/tables', '__@getTables')->middleware('admin');
Route::get('/', 'PortalController@index')->name('portal.index')->middleware('admin');
Route::post('portal/assign', 'PortalController@assign')->name('portal.assign')->middleware('admin');
Route::get('portal/shippers', 'PortalController@get_shippers')->name('portal.shippers')->middleware('admin');
Route::post('portal/status', 'PortalController@update_status')->name('portal.status')->middleware('admin');
Route::post('portal/transfers', 'PortalController@transfers')->name('portal.transfers')->middleware('admin');
Route::resource('roles', 'RolesController')->middleware('admin');
Route::resource('prices', 'PricesController')->middleware('admin');
Route::post('prices/status', 'PricesController@status')->name('prices.status')->middleware('admin');
Route::resource('pays', 'PaysController')->middleware('admin');
Route::post('pays/status', 'PaysController@status')->name('pays.status')->middleware('admin');
Route::resource('users', 'UsersController')->middleware('admin');
Route::post('users/status', 'UsersController@status')->name('users.status')->middleware('admin');
Route::resource('detail-shippers', 'DetailShipperController')->middleware('admin');
Route::post('detail-shippers/detail', 'DetailShipperController@detail')->name('detail-shippers.detail')->middleware('admin');
Route::get('provinces', 'ProvinceController@index')->name('provinces.index')->middleware('admin', 'user');
Route::get('districts', 'DistrictController@index')->name('districts.index')->middleware('admin', 'user');
Route::get('wards', 'WardController@index')->name('wards.index')->middleware('admin', 'user');
Route::resource('orders', 'OrdersController')->middleware('admin', 'user');
Route::post('orders/code', 'OrdersController@code')->name('orders.code')->middleware('admin', 'user');
Route::resource('units', 'UnitsController')->middleware('admin');

Auth::routes();
Route::get('logout', 'HomeController@logout')->name('logout');

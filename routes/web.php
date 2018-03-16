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
    return view('main');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'admin', 'middleware' => ['permission:Dashboard']], function() {

   	Route::get('/', 'Admin\Admin@index');

   	// for developer
	
	Route::group(['middleware' => ['permission:ManageRoles']], function() {
		Route::resource('/permissions', 'Admin\Permissions');
		Route::resource('/roles', 'Admin\Roles');
		
		Route::any('/allpermissions', 'Admin\Permissions@allPermissions');
		Route::any('/allroles', 'Admin\Roles@allRoles');
	});
	
	Route::group(['middleware' => ['permission:ManageUsers']], function() {
		Route::resource('/users', 'Admin\Users');
		
		Route::any('/allusers', 'Admin\Users@allUsers');
	});
	
	// for admin
	
	Route::resource('/pages', 'Admin\Pages');
	Route::resource('/car-makers', 'Admin\CarMakers');
	Route::resource('/car-models', 'Admin\CarModels');
	Route::resource('/cars', 'Admin\Cars');
	Route::resource('/stores', 'Admin\Stores');
	Route::resource('/parts', 'Admin\Parts');
	Route::resource('/stocks', 'Admin\Stocks');
	Route::resource('/discounts', 'Admin\Discounts');
	Route::resource('/images', 'Admin\Images');
	
	Route::any('/allpages', 'Admin\Pages@allPages');
	Route::any('/all-car-makers', 'Admin\CarMakers@allCarMakers');
	Route::any('/all-car-models', 'Admin\CarModels@allCarModels');
	Route::any('/all-cars', 'Admin\Cars@allCars');
	Route::any('/all-stores', 'Admin\Stores@allStores');
	Route::any('/all-parts', 'Admin\Parts@allParts');
	Route::any('/all-stocks', 'Admin\Stocks@allStocks');
	Route::any('/all-discounts', 'Admin\Discounts@allDiscounts');
});

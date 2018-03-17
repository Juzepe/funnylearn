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

Route::group(['prefix' => 'admin', 'middleware' => ['permission:ManageMaterials']], function() {
	Route::get('/', 'Admin\Admin@index');

	Route::group(['middleware' => ['permission:ManageRights']], function() {
		Route::resource('/roles', 'Admin\Roles');
		Route::resource('/permissions', 'Admin\Permissions');

		Route::any('/allroles', 'Admin\Roles@allRoles');
		Route::any('/allpermissions', 'Admin\Permissions@allPermissions');
	});

	Route::group(['middleware' => ['permission:ManageUsers']], function() {
		Route::resource('/users', 'Admin\Users');

		Route::any('/allusers', 'Admin\Users@allUsers');
	});

	Route::resource('/books', 'Admin\Books');

	Route::any('/allbooks', 'Admin\Books@allBooks');
});
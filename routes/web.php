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

Auth::routes();

Route::get('/', 'HomeController@main');

Route::get('/lesson/{id}', 'LessonController@show');
Route::get('/lesson/{id}/words', 'LessonController@words');

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
	Route::resource('/lessons', 'Admin\Lessons');
	Route::resource('/words', 'Admin\Words');

	Route::any('/allbooks', 'Admin\Books@allBooks');
	Route::any('/alllessons', 'Admin\Lessons@allLessons');
	Route::any('/allwords', 'Admin\Words@allWords');

	Route::get('/getLessons', 'Admin\Books@getLessons');
});
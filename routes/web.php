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
    return view('welcome');
});

Auth::routes();

//requires login
Route::group(['middleware' => ['auth']], function () {

    Route::get('eswift/home', 'HomeController@index')->name('home');

//Packages
    Route::get('/eswift/packages', 'PackageController@index')->name('packages');

    Route::get('/eswift/add/package', 'PackageController@show_add_package')->name('show_add_package');

    Route::post('add_package', 'PackageController@add_package')->name('add_package');

    Route::get('delete_package/{id}', 'PackageController@delete_package')->name('delete_package');

    Route::get('eswift/edit/package/{id}', 'PackageController@show_edit_package')->name('show_edit_package');

    Route::post('edit_package', 'PackageController@edit_package')->name('edit_package');

//Clients
    Route::get('eswift/clients', 'HomeController@view_all_clients')->name('clients');

    Route::get('eswift/client/add', 'AdminController@show_add_client')->name('show_add_client');

    Route::post('add_client', 'AdminController@add_client')->name('add_client');

    Route::get('delete_client/{id}', 'AdminController@delete_client')->name('delete_client');

    Route::get('eswift/edit/client/{id}', 'AdminController@show_edit_client')->name('show_edit_client');

    Route::post('edit_client/{id}', 'AdminController@edit_client')->name('edit_client');

    Route::get('eswift/client/details/{id}', 'AdminController@get_client_details')->name('client_details');

//Admin
    Route::get('eswift/admin/add', 'AdminController@show_add_admin')->name('show_add_admin');

    Route::post('add_admin', 'AdminController@add_admin')->name('add_admin');

    Route::get('eswift/admin/change_password', 'AdminController@show_change_password')->name('show_change_password');

    Route::post('change_password', 'AdminController@change_password')->name('change_password');

//Accountant

//Logs
    Route::get('eswift/admin/logs', 'AdminController@show_admin_logs')->name('show_admin_logs');

    Route::get('ewift/client/logs', 'AdminController@show_client_logs')->name('show_client_logs');

});
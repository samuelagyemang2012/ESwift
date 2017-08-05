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

//Global
Route::get('eswift', function () {
    return view('welcome');
});

Route::get('ewsift/logout', 'HomeController@logout')->name('logout');

//Admin
Route::get('eswift/admin/login', 'AdminController@show_login')->name('show_admin_login');

Route::post('admin_login', 'AdminController@login')->name('admin_login');

Route::group(['middleware' => 'admin'], function () {

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

//Logs
    Route::get('eswift/admin/logs', 'AdminController@show_admin_logs')->name('show_admin_logs');

    Route::get('ewift/client/logs', 'AdminController@show_client_logs')->name('show_client_logs');

});


//Transactions
Route::get('eswift/transactions/login', 'TransactionController@show_login')->name('show_transactions_login');

Route::post('transactions_login', 'TransactionController@login')->name('transactions_login');

Route::group(['middleware' => 'transactions'], function () {

    Route::get('eswift/transactions/', 'TransactionController@index')->name('transactions_home');

    Route::get('eswift/transactions/pending-loans', 'TransactionController@get_pending_loans')->name('transactions_pending_loans');

    Route::get('eswift/transactions/approved-loans', 'TransactionController@get_approved_loans')->name('transactions_approved_loans');

    Route::get('eswift/transactions/refused-loans', 'TransactionController@get_refused_loans')->name('transactions_refused_loans');

    Route::get('transactions/approve/{id}/{amount}', 'TransactionController@approve_loan')->name('transactions_approve');

    Route::get('transactions/refuse/{id}', 'TransactionController@refuse_loan')->name('transactions_refuse');

});


//Payment
Route::get('eswift/payments/login', 'PaymentController@show_login')->name('show_payments_login');

Route::post('payments_login', 'PaymentController@login')->name('payments_login');

Route::group(['middleware' => 'payments'], function () {

    Route::get('eswift/payments/', 'PaymentController@index')->name('payments_home');

    Route::get('eswift/payments/pending-transfers', 'PaymentController@get_pending_transfers')->name('pending_transfers');

    Route::get('eswift/payments/completed-transfers', 'PaymentController@get_completed_transfers')->name('completed_transfers');

    Route::get('eswift/payments/make-payment/{id}/{amount}', 'PaymentController@show_make_payment')->name('show_make_payment');

    Route::post('payments/make-payment', 'PaymentController@make_payment')->name('make_payment');

});
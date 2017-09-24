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
Route::get('', function () {
    return view('welcome');
});

Route::get('ewsift/logout', 'HomeController@logout')->name('logout');

//Super Admin
Route::get('eswift/super_admin/login', 'SuperAdminController@show_login')->name('show_super_login');

Route::post('super_admin_login', 'SuperAdminController@login')->name('super_admin_login');

Route::group(['middleware' => 'superadmin'], function () {

    Route::get('eswift/superadmin', 'SuperAdminController@index')->name('super_admin_home');

    Route::get('eswift/rate/{id}', 'SuperAdminController@show_edit_rate')->name('show_edit_rate');

    Route::get('eswift/admins', 'SuperAdminController@get_admins')->name('get_admins');

    Route::post('edit_rate', 'SuperAdminController@edit_rate')->name('edit_rate');

    Route::get('eswift/add_admin', 'SuperAdminController@show_admin')->name('show_add_admins');

    Route::post('add_admin', 'SuperAdminController@add_admin')->name('add_admin');
});

//------------------------------------------------------------------------------------------------------
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

    Route::get('/eswift/edit/package/{id}', 'PackageController@show_edit_package')->name('show_edit_package');

    Route::post('edit_package', 'PackageController@edit_package')->name('edit_package');

//Clients
    Route::get('eswift/clients', 'HomeController@view_all_clients')->name('clients');

    Route::get('eswift/client/add', 'AdminController@show_add_client')->name('show_add_client');

    Route::post('add_client', 'AdminController@add_client')->name('add_client');

    Route::get('eswift/delete_client/{id}/{telephone}', 'AdminController@delete_client')->name('delete_client');

    Route::get('eswift/edit/client/{id}', 'AdminController@show_edit_client')->name('show_edit_client');

    Route::post('edit_client/{id}', 'AdminController@edit_client')->name('edit_client');

    Route::get('eswift/client/details/{id}', 'AdminController@get_client_details')->name('client_details');

    Route::get('eswift/payments_personnel', 'AdminController@get_payements_personnel')->name('payments_personnel');

    Route::get('eswift/transactions_personnel', 'AdminController@get_transactions_personnel')->name('transactions_personnel');

//Admin
//    Route::get('eswift/admin/add-admin', 'AdminController@show_add_admin')->name('show_add_admin');
//
//    Route::post('eswift/add_admin', 'AdminController@add_admin')->name('add_admin');

    Route::get('eswift/admin/change_password', 'AdminController@show_change_password')->name('show_change_password');

    Route::post('change_password', 'AdminController@change_password')->name('change_password');

//Logs
    Route::get('eswift/admin/logs', 'AdminController@show_admin_logs')->name('show_admin_logs');

    Route::get('eswift/client/logs', 'AdminController@show_client_logs')->name('show_client_logs');

//Debts
    Route::get('eswift/debts', 'AdminController@get_debts')->name('get_debts');

//Loans
    Route::get('eswift/loans', 'AdminController@get_all_loans')->name('admin_get_all_loans');

    Route::get('eswift/loans/pending', 'AdminController@get_pending_loans')->name('admin_get_pending_loans');

    Route::get('eswift/loans/approved', 'AdminController@get_approved_loans')->name('admin_get_approved_loans');

    Route::get('eswift/loans/rejected', 'AdminController@get_refused_loans')->name('admin_get_refused_loans');

    Route::get('eswift/approve/{amount}/{user_id}/{loan_id}/{telephone}', 'AdminController@approve_loan')->name('admin_approve');

    Route::get('eswift/refuse/{id}/{amount}/{telephone}', 'AdminController@refuse_loan')->name('admin_refuse');


//Payments
    Route::get('eswift/admin/pending-transfers', 'AdminController@get_pending_payments')->name('admin_pending_payments');

    Route::get('eswift/admin/completed-transfers', 'AdminController@get_completed_payments')->name('admin_completed_payments');

    Route::get('eswift/admin/make-payment/{id}/{amount}/{user_id}/{telephone}/{loan_id}', 'AdminController@show_make_payments')->name('admin_show_make_payments');

    Route::post('eswift/admin/make_payment', 'AdminController@make_payment')->name('admin_make_payment');

//Add Payment
    Route::get('eswift/admin/add/payment-personnel', 'AdminController@show_add_payment')->name('show_add_payment');

    Route::post('eswift/add_payment', 'AdminController@add_payment')->name('add_payment');

    Route::get('eswift/admin/add/transaction-personnel', 'AdminController@show_add_transaction')->name('show_add_transaction');

    Route::post('eswift/add_transaction', 'AdminController@add_transaction')->name('add_transaction');

    Route::get('eswift/delete_payments/{id}', 'AdminController@delete_payments')->name('delete_payments');

    Route::get('eswift/delete_transactions/{id}', 'AdminController@delete_transactions')->name('delete_transactions');

    Route::get('eswift/edit/payments/{id}', 'AdminController@show_edit_payment')->name('show_edit_payment');

    Route::get('eswift/edit/transactions/{id}', 'AdminController@show_edit_transaction')->name('show_edit_transaction');

    Route::post('edit_payments/{id}', 'AdminController@edit_payments_personnel')->name('edit_payments_personnel');

    Route::post('edit_transactions/{id}', 'AdminController@edit_transactions_personnel')->name('edit_transactions_personnel');

    Route::get('eswift/accounts', 'AdminController@show_accounts')->name('show_accounts');

    Route::get('eswift/accounts/{id}', 'AdminController@show_edit_account')->name('edit_account');

    Route::post('update_accounts/{id}', 'AdminController@update_accounts')->name('update_account');

    Route::get('eswift/debt/{loan_id}', 'AdminController@get_debt_details')->name("get_debt_details");

//    Notifications
    Route::get('eswift/notifications/unread', 'AdminController@get_unread')->name("get_unread");

    Route::get('eswift/notifications/read', 'AdminController@get_read')->name("get_read");

    Route::get('eswift/mark/{id}', 'AdminController@mark_as_read')->name('mark');

    Route::get('eswift/loans/half_loans_due', 'AdminController@get_half_loans_due')->name('half_loans_due');

    Route::get('eswift/loans/elapsed_loans', 'AdminController@get_elapsed_loans')->name('elapsed_loans');

    Route::get('eswift/account_deductions/{id}', 'AdminController@show_edit_account_hld')->name('edit_account_hld');

    Route::post('update_account_hld/{id}', 'AdminController@update_accounts_hld')->name('update_account_hld');

});

//--------------------------------------------------------------------------------------------------------
//Transactions Module
Route::get('eswift/transactions/login', 'TransactionController@show_login')->name('show_transactions_login');

Route::post('transactions_login', 'TransactionController@login')->name('transactions_login');

Route::group(['middleware' => 'transactions'], function () {

    Route::get('eswift/transactions/', 'TransactionController@index')->name('transactions_home');

    Route::get('eswift/transactions/pending-loans', 'TransactionController@get_pending_loans')->name('transactions_pending_loans');

    Route::get('eswift/transactions/approved-loans', 'TransactionController@get_approved_loans')->name('transactions_approved_loans');

    Route::get('eswift/transactions/rejected-loans', 'TransactionController@get_refused_loans')->name('transactions_refused_loans');

    Route::get('eswift/transactions/approve/{amount}/{user_id}/{loan_id}/{telephone}', 'TransactionController@approve_loan')->name('transactions_approve');

    Route::get('eswift/transactions/refuse/{id}/{amount}/{telephone}', 'TransactionController@refuse_loan')->name('transactions_refuse');

    Route::get('eswift/transactions/logs', 'TransactionController@logs')->name('transactions_log');
});

//--------------------------------------------------------------------------------------------------------

//Payment Module
Route::get('eswift/payments/login', 'PaymentController@show_login')->name('show_payments_login');

Route::post('payments_login', 'PaymentController@login')->name('payments_login');

Route::group(['middleware' => 'payments'], function () {

    Route::get('eswift/payments/', 'PaymentController@index')->name('payments_home');

    Route::get('eswift/payments/pending-transfers', 'PaymentController@get_pending_transfers')->name('pending_transfers');

    Route::get('eswift/payments/completed-transfers', 'PaymentController@get_completed_transfers')->name('completed_transfers');

    Route::get('eswift/payments/make-payment/{id}/{amount}/{user_id}/{telephone}/{loan_id}', 'PaymentController@show_make_payment')->name('show_make_payment');

    Route::post('payments/make-payment', 'PaymentController@make_payment')->name('make_payment');

    Route::get('eswift/payments/logs', 'PaymentController@logs')->name('payments_log');

});


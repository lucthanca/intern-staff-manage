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

Route::group(['namespace' => 'User'], function () {
    Route::get('/', 'RootController@index');
    Route::get('staff/', 'RootController@StaffIndex')->name('root.staff.index');
    Route::get('new-staff', 'RootController@create');
    Route::post('store-staff', 'RootController@store')->name('root.store');
    Route::post('resetPasswordFirst', 'RootController@resetPasswordFirst')->name('resetPasswordFirst');
    Route::get('edit/{user}', 'RootController@edit');
    Route::post('update', 'RootController@update')->name('root.update');
    Route::post('destroy', 'RootController@deleteA')->name('root.deleteA');
    Route::post('multi-delete','RootController@multiDelete')->name('multiDelete');

    Route::get('ajaxLoadStaff','RootController@ajaxLoadStaff')->name('ajaxLoadStaff');

    Route::post('rs-pw/','RootController@sendEmailReset')->name('sendEmailReset');
    Route::get('reset-password/{token}','RootController@showFormResetPassword');
    Route::post('resetAPswd','RootController@resetPswd')->name('resetAPswd');

    Route::post('rs-multi-pw/','RootController@sendMultiEmailReset')->name('sendMultiEmailReset');

    Route::get('profile/{user}','RootController@show');
    Route::post('updateNameAddressBirthdayAndPhone', 'RootController@updateNameAddressBirthdayAndPhone')->name('updateNameAddressBirthdayAndPhone');
    Route::post('updateAvatar', 'RootController@updateAvatar')->name('updateAvatar');
    Route::post('addToDepartment', 'RootController@addToDepartment')->name('addToDepartment');
    Route::post('kichOutFromDepartment', 'RootController@kichOutFromDepartment')->name('kichOutFromDepartment');

    Route::post('pushToIdSession', 'RootController@pushToIdSession')->name('pushToIdSession');
});

Route::group(['namespace' => 'Department'], function () {
    Route::get('department', 'DepartmentController@departmentIndex');
    Route::get('new-department', 'DepartmentController@create');
    Route::post('store-department', 'DepartmentController@store')->name('department.store');
    Route::get('department/{department}/edit', 'DepartmentController@edit');
    Route::post('update-department', 'DepartmentController@update')->name('department.update');
    Route::post('delete-a-department', 'DepartmentController@deleteADepartment')->name('department.deleteADepartment');
    Route::get('department/{department}', 'DepartmentController@showDepartment');
    Route::post('addStaffToDepartment', 'DepartmentController@addStaffToDepartment')->name('department.addStaffToDepartment');
    Route::post('searchStaff', 'DepartmentController@searchStaff')->name('searchStaff');
    Route::post('kickAStaff', 'DepartmentController@kickAStaff')->name('kickAStaff');
    Route::post('setToStaff', 'DepartmentController@setToStaff')->name('setToStaff');
    Route::post('setAsManage', 'DepartmentController@setAsManage')->name('setAsManage');
    Route::post('hasManage', 'DepartmentController@hasManage')->name('hasManage');
    Route::post('multiKick', 'DepartmentController@multiKick')->name('multiKick');
    Route::post('searchDepartment', 'DepartmentController@searchDepartment')->name('searchDepartment');
});

Route::group(['namespace' => 'Excel'], function () {
    Route::get('exportStaff', 'ExportController@exportStaff')->name('exportStaff');
    Route::get('exportStaffFromDepartment/{department}', 'ExportController@exportStaffFromDepartment')->name('exportStaffFromDepartment');
});

Route::group(['namespace' => 'Auth'], function () {
    Route::get('forgot-password','ForgotPasswordController@index');
    Route::get('send-reset-password-mail','ForgotPasswordController@sendResetPasswordMail')->name('send-reset-password-mail');
    Route::get('reset-pass/{token}', 'ForgotPasswordController@showFormResetPassword');
});

Route::get('/home', 'HomeController@index')->name('home');

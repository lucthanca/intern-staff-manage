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
});

Route::get('/home', 'HomeController@index')->name('home');

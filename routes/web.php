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

Route::group(['namespace'=>'User'],function(){
    Route::get('/', 'RootController@index');
    Route::get('/staff/','RootController@StaffIndex')->name('root.staff.index');
    Route::get('new-staff', 'RootController@create');
    Route::post('store-staff', 'RootController@store')->name('root.store');
});

Route::get('/home', 'HomeController@index')->name('home');
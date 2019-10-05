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


Route::get('/', 'HomeController@index')->name('home');


Auth::routes();

// // Disable the register controller
// Auth::routes(['register' => false]);


Route::get('/apimanagement', 'ApiManagementController@index')->middleware(['auth', 'auth.admin']);


Route::namespace('Admin')->prefix('admin')->name('admin.')->group(function() {

    Route::resource('/users', 'UsersController')->middleware(['auth', 'auth.admin']);

    //Route for the Bidding Schedule actions.
    Route::resource('/bidding-schedule', 'BiddingSchedule')->middleware(['auth', 'auth.admin']);
});


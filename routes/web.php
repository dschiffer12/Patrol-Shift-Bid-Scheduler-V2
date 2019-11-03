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


Route::get('/', 'HomeController@index')->name('home')->middleware(['auth']);


Auth::routes();

// // Disable the register controller
// Auth::routes(['register' => false]);


Route::get('/apimanagement', 'ApiManagementController@index')->middleware(['auth', 'auth.admin']);


Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'auth.admin'])->name('admin.')->group(function() {
    Route::resource('/users', 'UsersController');

    //Route for the Bidding Schedule actions.
    Route::resource('/bidding-schedule', 'BiddingSchedule');
    Route::resource('/bidding-queue', 'BiddingQueueController');
});


Route::namespace('User')->prefix('user')->middleware(['auth'])->name('user.')->group(function() {
    Route::get('/biddingschedule/bids', 'BiddingController@bids')->name('biddingschedule.bids');
    Route::resource('/profile', 'ProfileController');
    Route::resource('/psheet', 'PSheetController');
    Route::resource('/biddingschedule', 'BiddingController');
});

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
Route::get('/home', 'HomeController@index')->name('home')->middleware(['auth']);


Auth::routes();

// // Disable the register controller
// Auth::routes(['register' => false]);

// Note to self: When cleaning up, I need to disable/except unused function from resource routes

Route::get('/apimanagement', 'ApiManagementController@index')->middleware(['auth', 'auth.admin']);


Route::namespace('Admin')->prefix('admin')->middleware(['auth', 'auth.admin'])->name('admin.')->group(function() {
    Route::resource('/users', 'UsersController');


    //Route for the Schedule controller.
    Route::resource('/schedules', 'ScheduleController');
    Route::resource('/schedules/{id}/edit', 'ScheduleController@edit');
    Route::post('/schedules/{id}/addShift', 'ScheduleController@addShift')->name('schedules.addShift');
    Route::post('/schedules/{id}/addSpot', 'ScheduleController@addSpot')->name('schedules.addSpot');
    Route::post('/schedules/{id}/deleteSpot', 'ScheduleController@deleteSpot')->name('schedules.deleteSpot');
    Route::post('/schedules/{id}/deleteShift', 'ScheduleController@deleteShift')->name('schedules.deleteShift');
    Route::get('/schedules/{id}/addUsers', 'ScheduleController@addUsers')->name('schedules.addUsers');
    Route::post('/schedules/{id}/storeQueue', 'ScheduleController@storeQueue')->name('schedules.storeQueue');
    Route::get('/schedules/{id}/reviewSchedule', 'ScheduleController@reviewSchedule')->name('schedules.reviewSchedule');
    Route::get('/schedules/{id}/activateSchedule', 'ScheduleController@activateSchedule')->name('schedules.activateSchedule');
    Route::get('/schedules/{id}/approveSchedule', 'ScheduleController@approveSchedule')->name('schedules.approveSchedule');
    Route::post('/schedules/saveApproval', 'ScheduleController@saveApproval')->name('schedules.saveApproval');
    Route::get('/schedules/{id}/viewApproved', 'ScheduleController@viewApproved')->name('schedules.viewApproved');

    // bidding queue
    Route::get('/schedule/{id}/biddingQueue', 'BidQueueController@view')->name('schedules.biddingQueue');
    Route::get('/schedule/{id}/viewbid', 'BidQueueController@viewbid')->name('schedules.viewbid');
    Route::post('/schedules/{id}/bid', 'BidQueueController@bid')->name('schedules.bid');
    Route::post('/schedules/bidforuser', 'BidQueueController@bidforuser')->name('schedules.bidforuser');

    // specialties
    Route::get('/specialties', 'SpecialtyController@index')->name('specialties');
    Route::post('/specialties/add', 'SpecialtyController@add')->name('specialties.add');
    Route::get('/specialties/{id}/delete', 'SpecialtyController@delete')->name('specialties.delete');

    // roles
    Route::get('/roles', 'RoleController@index')->name('roles');
    Route::post('/roles/add', 'RoleController@add')->name('roles.add');
    Route::get('/roles/{id}/delete', 'RoleController@delete')->name('roles.delete');
});


Route::namespace('User')->prefix('user')->middleware(['auth'])->name('user.')->group(function() {
    Route::resource('/profile', 'ProfileController');
    Route::get('/psheet/date', 'PSheetController@date')->name('psheet.date');
    Route::resource('/psheet', 'PSheetController');

    Route::get('/schedules', 'ScheduleController@index')->name('schedules.view');
    Route::get('/schedules/{id}/bid', 'ScheduleController@bid')->name('schedules.bid');
    Route::post('/schedules/store', 'ScheduleController@store')->name('schedules.store');
    Route::get('/schedules/{id}/viewbid', 'ScheduleController@viewBid')->name('schedules.viewbid');

});

// The catch-all will match anything except the previous defined routes.
Route::any('{catchall}', 'CatchAllController@handle')->where('catchall', '.*');

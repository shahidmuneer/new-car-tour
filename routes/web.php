<?php

use App\Http\Controllers\LocaleController;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */
Route::get("/process-order","App\Http\Controllers\Backend\FormController@index");

Route::get("/process-order/{tourType}","App\Http\Controllers\Backend\FormController@tour");

// Switch between the included languages
Route::get('lang/{lang}', [LocaleController::class, 'change'])->name('locale.change');

/*
 * Frontend Routes
 */
Route::group(['as' => 'frontend.'], function () {
    includeRouteFiles(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 *
 * These routes can only be accessed by users with type `admin`
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    includeRouteFiles(__DIR__.'/backend/');
});

Route::group(['namespace'=>'App\Http\Controllers','prefix'=>'backend'],function () {

    Route::resource('cars', 'Backend\CarController');
    Route::resource('modals', 'Backend\ModalController');
    Route::resource('category', 'Backend\CategoryController');
    Route::resource('plans', 'Backend\PlanController');
    Route::resource('packages', 'Backend\PackageController');
    Route::resource('packagecategory', 'Backend\PackageController');
    Route::resource('packageprice', 'Backend\PackagePriceController');



});

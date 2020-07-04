<?php

/*
|--------------------------------------------------------------------------
| Roles Routes
|--------------------------------------------------------------------------
 */
Route::name('roles.')->prefix('roles')->group(function () {
    Route::get('/')->name('index')->uses('Api\RoleController@index');
    // Route::get('create')->name('create')->uses('RoleController@create');
    // Route::post('create')->name('store')->uses('RoleController@store');
    // Route::get('{id}')->name('edit')->uses('RoleController@edit');
    // Route::put('{id}')->name('update')->uses('RoleController@update');
    // Route::delete('{id}')->name('delete')->uses('RoleController@delete');

});
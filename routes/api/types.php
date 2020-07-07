<?php

/*
|--------------------------------------------------------------------------
| Types Routes
|--------------------------------------------------------------------------
 */
Route::name('types.')->prefix('types')->group(function () {
    Route::get('/')->name('index')->uses('Api\TypeController@index');
    // Route::get('create')->name('create')->uses('RoleController@create');
    Route::post('create')->name('store')->uses('Api\TypeController@store');
    Route::get('{id}')->name('edit')->uses('Api\TypeController@edit');
    Route::put('{id}')->name('update')->uses('Api\TypeController@update');
    Route::delete('{id}')->name('delete')->uses('Api\TypeController@delete');

});
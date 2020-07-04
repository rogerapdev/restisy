<?php

/*
|--------------------------------------------------------------------------
| Permissions Routes
|--------------------------------------------------------------------------
 */
Route::name('permissions.')->prefix('permissions')->group(function () {
    Route::get('/')->name('index')->uses('Api\PermissionController@index');
});
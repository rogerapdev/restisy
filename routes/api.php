<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/register', 'Api\AuthController@register');
Route::post('/login', 'Api\AuthController@login');
Route::get('/unauthorized', 'Api\AuthController@unauthorized');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::bind('id', function ($id) { return Hasher::decode($id);});

Route::group(['middleware' => ['auth:api', 'auth.permissions']], function () {
    $files = glob(__DIR__ . '/api/*.php');
    foreach ($files as $file) {
        require_once $file;
    }
});
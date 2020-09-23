<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'v1'], function () {
    Route::group(['prefix' => 'user', 'namespace' => 'user'], function () {
        Route::post('create', 'UserController@create');     //新增會員
        Route::post('delete', 'UserController@delete');     //刪除會員
        Route::post('pwd/change', 'UserController@update'); //修改會員密碼
        Route::get('login', 'UserController@login');        //驗證帳號密碼
    });
});
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

Route::get('/', function () {
    return Redirect::route('api.index');
});

Route::group(['prefix'=>'api','namespace'=>'Api','as'=>'api.'],function (){
    Route::any('index','Wechat\WechatController@index')->name('index');

});


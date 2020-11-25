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
//    return Redirect::route('api.index');
    //重定向路由
    return 'hello word';
//    return Redirect::to('/home');
//重定向命名路由
//return Redirect::route('website.home');
//重定向到控制器动作
//return Redirect::action('homeController@home');
});
/*
 * 微信公众号
 */
Route::group(['prefix' => 'api', 'namespace' => 'Api', 'as' => 'api.'], function () {
    //首次接入
    Route::any('index', 'Wechat\WechatController@index')->name('index');
    //测试获取access_token
    Route::any('ceshi', 'Wechat\WechatController@ceshi')->name('ceshi');
    Route::any('createMenu', 'Wechat\WechatController@createMenu')->name('createMenu');
    Route::any('delMenu', 'Wechat\WechatController@delMenu')->name('delMenu');
});


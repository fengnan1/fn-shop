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
//定义自己的路由文件 避免冲突
//include  base_path('route/admin/admin.php');
Route::get('/', function () {
    return Redirect::route('admin.login');
    //重定向路由
//    return 'hello word';
//    return Redirect::to('/home');
//重定向命名路由
//return Redirect::route('website.home');
//重定向到控制器动作
//return Redirect::action('Admin/ManagerController@login');
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
/*
* 后台
*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::match(['get', 'post'], 'login', 'LoginController@login')->name('login');
    Route::group(['middleware'=>'CheckManager:login'],function (){
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::get('index', 'IndexController@index')->name('index');
        Route::get('welcome', 'IndexController@welcome')->name('welcome');
    });



});

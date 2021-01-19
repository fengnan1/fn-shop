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
    Route::get('index', 'Wechat\MaterialController@index')->name('material.index');//素材列表
    Route::any('upload', 'Wechat\MaterialController@upload')->name('material.upload');//上传素材

});
/*
* 后台
*/
Route::group(['prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin.'], function () {
    Route::match(['get', 'post'], 'login', 'LoginController@login')->name('login');
    Route::group(['middleware' => 'CheckManager:login'], function () {
        Route::get('logout', 'LoginController@logout')->name('logout');
        Route::get('index', 'IndexController@index')->name('index');
        Route::get('welcome', 'IndexController@welcome')->name('welcome');

        route::get('sendmail', function () {
            //发送文本邮件
//        \Mail::raw('测试一下发邮件',function (\Illuminate\Mail\Message $messages){
//            //获取回调方法中的形参
////            dd(func_get_args());
//            $messages->to('811264657@qq.com');
//
//            $messages->subject('测试一下发邮件');

//        });
//            发送文本邮件
            \Mail::send('mail.adduser',['data'=>['username'=>'张三','email'=>'811264657@qq.com']], function (\Illuminate\Mail\Message $messages) {
                //获取回调方法中的形参
//            dd(func_get_args());
                $messages->to('811264657@qq.com');

                $messages->subject('测试一下发邮件');

            });


        })->name('sendmail');

        //管理员用户状态
        Route::put('managers/edit_status/{id}', 'ManagerController@edit_status')->name('managers.edit_status');
        //恢复删除
        Route::post('managers/restores/{id}', 'ManagerController@restores')->name('managers.restores');
        //全选删除
        Route::delete('managers/patch_delete', 'ManagerController@patch_delete')->name('managers.patch_delete');
        //管理员资源
        Route::resource('managers', 'ManagerController');

        //角色资源
        Route::resource('roles', 'RoleController');

        //权限资源
        Route::resource('nodes', 'NodeController');

        //商品资源
        Route::resource('goods', 'GoodsController');


    });


});

<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Node;
class LoginController extends Controller
{
  public function  login(Request $request){
        if (auth('admin')->check()){
            return redirect(route('admin.index'));
        }

      if ($request->isMethod('post')){

          $data=$this->validate($request, [
              'username' => ["required"],
              'password' => ['required'],
          ]);
//          dd(Auth::guard('web')->attempt($data));
          $bool=auth('admin')->attempt($data);

          if ($bool){
                //判断是否是超级管理员
              if (auth('admin')->user()->username ===config('rbac.super')) {

                  $auth=getChild(Node::get()->toArray());

              } else {
                  //获取该用户拥有的权限
                  $node = auth('admin')->user()->role->nodes()->pluck('route_name', 'id')->toArray();
                  $auth =getChild(Node::whereIn('id', array_keys($node))->get()->toArray());
                  session(['admin.node'=>$node]);


              }
              session(['admin.auth'=>$auth]);
              return redirect(route('admin.index'))->with(['success'=>'登陆成功']);

          }else{
              return redirect(route('admin.login'))->withErrors(['error'=>'用户名或密码错误']);
          }
      }else{
          return view('admin.manager.login');

      }

  }


  public function  logout(){

      auth('admin')->logout();
      return redirect(route('admin.login'))->with(['success'=>'已成功退出']);
  }


}

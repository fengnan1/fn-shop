<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
  public function  login(Request $request){

      if ($request->isMethod('post')){
          dd($request->all());
      }else{
          return view('admin.manager.login');

      }

  }
}

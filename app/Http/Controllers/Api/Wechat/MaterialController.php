<?php

namespace App\Http\Controllers\Api\Wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MaterialController extends Controller
{

    public function index(){
        return view('admin.material.index');
    }


    public function upload(){
        return view('admin.material.add');
    }

    //临时素材
    public function temporary()
    {

    }
    //永久素材
    public function permanent()
    {

    }
}


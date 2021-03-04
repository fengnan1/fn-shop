<?php

namespace App\Http\Controllers\Admin;

use App\Models\Node;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class IndexController extends Controller
{
    public function welcome()
    {
        return view('admin.index.welcome');
    }

    public function index()
    {

        $auth = session('admin.auth');
//dd($auth);


        return view('admin.index.index', ['data' => $auth]);

    }
}

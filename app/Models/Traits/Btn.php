<?php

namespace App\Models\Traits;


trait Btn
{

    public function showBtn(string $route)
    {
        if (auth('admin')->user()->username!=config('rbac.super')&&!in_array($route,session('admin.node'))){
          return '';
        }
        return '<a class=" label label-success radius show"  href="javascript:;"
                           data-url="'.route($route,$this).'"data-title="查看权限"style="text-decoration:none">点击查看</a>';
    }


    public function  editBtn(string $route){
        if (auth('admin')->user()->username!=config('rbac.super')&&!in_array($route,session('admin.node'))){
            return '';
        }

        return '<a class=" label label-warning radius edit"  href="javascript:;"
                           data-url="'.route($route,$this).'"data-title="修改权限"style="text-decoration:none">修改</a>';

    }

    public  function delBtn(string $route){

        if (auth('admin')->user()->username!=config('rbac.super')&&!in_array($route,session('admin.node'))){
            return '';
        }

        return '<a class=" label label-danger radius delete"  href="javascript:;"
                           data-url="'.route($route,$this).'"data-title="删除权限"style="text-decoration:none">删除</a>';
    }
}
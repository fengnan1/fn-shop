<?php

namespace App\Models;


class Node extends Base
{
    //可以赋值的字段
    protected $fillable = ['node_name','route_name','icon','is_menu','pid'];

    //时间字段自动完成
    public $timestamps = false;

    // 是否是菜单
    public function getIsMenuAttribute($value)
    {
            return $value? $this->attributes['is_menu'] = '是':$this->attributes['is_menu'] = '否';


    }
    // 是否有路由别名
    public function getRouteNameAttribute($value)
    {
            return $value?$this->attributes['route_name'] = $value:$this->attributes['route_name'] = '作为菜单没有路由别名';

    }

//    public function getIconAttribute($value)
//    {
//        return $value?$this->attributes['route_name'] = '&#-'."$value":$this->attributes['route_name'] = '';
//
//    }

    public function setRouteNameAttribute($value)
    {
        if ($value=='作为菜单没有路由别名'){
            return $this->attributes['route_name']='';
        }else{
            return $this->attributes['route_name']=$value;
        }
    }
}

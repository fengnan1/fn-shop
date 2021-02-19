<?php

namespace App\Models;


class Node extends Base
{
    //可以赋值的字段
    protected $fillable = ['node_name','route_name','icon','is_menu','pid'];

    //时间字段自动完成
    public $timestamps = false;

    // 是否是菜单
    public function getMenuAttribute()
    {
            return $this->is_menu?'<span  class="label label-success radius">是</span>':'<span  class="label label-danger radius">否</span>';


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
    public function setIconAttribute($value)
    {
       return $this->attributes['icon']=empty($value)?'':htmlspecialchars($value);
    }

    public function roles(){

        return $this->belongsToMany(Role::class,'roles_nodes','node_id','role_id');
    }

}

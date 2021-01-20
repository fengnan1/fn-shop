<?php

namespace App\Models;


class Node extends Base
{
    //可以赋值的字段
    protected $fillable = ['node_name','route_name','icon','is_menu','pid'];

    //时间字段自动完成
    public $timestamps = false;
}

<?php

namespace App\Models;


class Role extends Base
{

    //可以赋值的字段
    protected $fillable = ['role_name'];

    //时间字段自动完成
    public $timestamps = false;

    public function nodes(){

        return $this->belongsToMany(Node::class,'roles_nodes','role_id','node_id');
    }

}

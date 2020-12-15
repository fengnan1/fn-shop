<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Manager extends  Authenticatable
{
    //可以赋值的字段
    protected $fillable = ['username','truename','password','gender','role_id','email','mobile','status','sort'];

    //时间字段自动完成
    public $timestamps = true;
//    隐藏字段的字段
    protected $hidden=['password'];
}

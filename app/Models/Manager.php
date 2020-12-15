<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manager extends Model
{
    //可以赋值的字段
    protected $fillable = ['username','truename','password','gender','role_id','email','mobile','status','sort'];

    //时间字段自动完成
    public $timestamps = true;
//    不能被赋值的字段
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
class Manager extends Authenticatable
{
    use SoftDeletes;
    //可以赋值的字段
    protected $fillable = ['username', 'truename', 'password', 'gender', 'role_id', 'email', 'mobile', 'status', 'sort'];

    //时间字段自动完成
    public $timestamps = true;
//    隐藏字段的字段
    protected $hidden = ['password'];

    //软删除标识字段
    protected $dates=['deleted_at'];

    //    默认给数据库字段赋值
    protected $attributes = [
        'role_id' => 2,
        'status' => 1,
    ];

//访问器get 。。。。性别显示
    public function getGenderAttribute($value)
    {

        switch ($value) {
            case "1":
                return $this->attributes['gender'] = '男';
                break;
            case "2":
                return $this->attributes['gender'] = '女';
                break;
            default:
                return $this->attributes['gender'] = '保密';
        }
    }

// 邮箱是否验证
    public function getEmailVerifiedAttribute($value)
    {
        if ($value) {
            return $this->attributes['email_verified'] = '已验证';
        } else {
            return $this->attributes['email_verified'] = '未验证';
        }
    }

    public function role(){
        return $this->belongsTo(Role::class,'role_id','id');
    }
}

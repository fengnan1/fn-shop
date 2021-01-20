<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Base extends Model
{
    use SoftDeletes;

    //软删除标识字段
    protected $dates=['deleted_at'];


}

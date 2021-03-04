<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Btn;
class Base extends Model
{
    use SoftDeletes,Btn;

    //软删除标识字段
    protected $dates=['deleted_at'];


}

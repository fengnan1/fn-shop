<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManagersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('managers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('username',20)->comment('用户名');
            $table->string('password',255)->comment('密码');
            $table->enum('password',[1,2,3])->comment('性别 1:男2:女3:保密');
            $table->string('mobile',15)->comment('手机号');
            $table->string('email',40)->comment('邮箱');
            $table->tinyInteger('role_id')->comment('角色id');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
            $table->enum('status',[1,2])->comment('账号状态 1:启用2:禁用');
            $table->tinyInteger('sort')->default(50)->comment('排序');
            $table->softDeletes();
            $table->timestamps();

        });
        DB::statement("ALTER TABLE `managers` comment'管理员表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('managers');
    }
}

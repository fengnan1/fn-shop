<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nodes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('node_name',20)->notNull()->comment('权限名称');
            $table->string('route_name',100)->nullable()->comment('路由别名，权限认证标识');
            $table->string('icon',50)->nullable()->comment('图标');
            $table->enum('is_menu',[0,1])->default('0')->comment('是否是菜单 0:否 1:是');
            $table->tinyInteger('pid')->default(0)->comment('上级id');
            $table->softDeletes();

        });
        DB::statement("ALTER TABLE `nodes` comment'权限表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('nodes');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RoleNode extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_node', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->notNull()->comment('角色id');
            $table->unsignedInteger('node_id')->notNull()->comment('权限id');

        });
        DB::statement("ALTER TABLE `role_node` comment'角色权限表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_node');
    }
}

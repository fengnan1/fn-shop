<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title', 255)->comment('文章标题');
            $table->string('digest', 255)->comment('文章摘要');
            $table->string('url', 100)->comment('文章封面');
            $table->text('content')->comment('文章内容');
            $table->string('author',50)->default('')->comment('文章作者');
            $table->string('source')->default('')->comment('文章来源');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}

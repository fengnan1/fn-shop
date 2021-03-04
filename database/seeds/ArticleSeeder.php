<?php

use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //先清空数据表
        \App\Models\Article::truncate();
        //生成测试数据
        factory(\App\Models\Article::class,30)->create();


    }
}

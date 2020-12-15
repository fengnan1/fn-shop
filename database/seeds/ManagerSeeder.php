<?php

use Illuminate\Database\Seeder;

use App\Models\Manager;
class ManagerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //先清空数据表
        Manager::truncate();
        //生成测试数据
        factory(Manager::class,100)->create();

        Manager::where('id',1)->update(['username'=>'admin','role_id'=>1]);


    }
}

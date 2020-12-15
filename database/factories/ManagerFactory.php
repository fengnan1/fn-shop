<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Manager::class, function (Faker $faker) {
    return [

            'username'=>$faker->userName,
            'truename'=>$faker->name,
            'password'=>bcrypt(123456),
            'gender'=>rand(1,3),
            'role_id'=>rand(2,5),
            'email'=>$faker->email,
            'mobile'=>$faker->phoneNumber,
            'status'=>rand(1,2),
            'sort'=>50,

    ];
});

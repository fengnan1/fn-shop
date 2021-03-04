<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Article::class, function (Faker $faker) {
    return [
        'title'=>$faker->title,
        'digest'=>$faker->word,
        'url'=>'uploads/article/'.rand(1,5).'.jpg',
        'content'=>$faker->text,
    ];
});

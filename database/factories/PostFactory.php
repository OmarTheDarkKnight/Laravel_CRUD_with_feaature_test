<?php

use Faker\Generator as Faker;

$factory->define(App\Post::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'body' => $faker->paragraph,
        'user_id' => factory('App\User')->create()->id,
        'cover_image' => 'noImage.jpg',
    ];
});

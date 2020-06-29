<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Like;
use App\Status;
use App\User;
use Faker\Generator as Faker;

$factory->define(Like::class, function (Faker $faker) {
    return [
        'user_id' => function(){
            return factory(User::class)->create();
        },
    ];
});

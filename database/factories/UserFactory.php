<?php

declare(strict_types=1);

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Base\Model\Lang\Lang;
use App\Base\Model\Security\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    static $password = null;

    return [
        'lang_id' => Lang::inRandomOrder()->first()->lang_id,
        'email' => uniqid().'@albertcito.com',
        'password' => $password ?: $password = bcrypt('123456'),
        'name' => $faker->name,
        'user_status_id' => 'active',
        'remember_token' => Str::random(10),
        'email_verified' => rand(0, 1),
    ];
});

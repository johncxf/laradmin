<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Admin;
use Faker\Generator as Faker;

$factory->define(Admin::class, function (Faker $faker) {
    return [
        'username' => $faker->name,
        'nickname' => $faker->name,
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'email' => $faker->unique()->safeEmail,
        'login_time' => date('Y-m-d H:i:s', time()),
        'token' => '123',
        'create_at' => date('Y-m-d H:i:s', time()),
        'update_at' => date('Y-m-d H:i:s', time()),
    ];
});

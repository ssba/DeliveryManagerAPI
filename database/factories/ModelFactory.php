<?php

use Webpatser\Uuid\Uuid;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\UserType::class, function (Faker\Generator $faker) {

    return [
        'guid' => Uuid::generate(4),
        'type' => $faker->unique()->word,
        'desc' => $faker->unique()->text
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\RouteLogType::class, function (Faker\Generator $faker) {

    return [
        'guid' => Uuid::generate(4),
        'type' => $faker->unique()->word,
        'desc' => $faker->unique()->text
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Car::class, function (Faker\Generator $faker) {
    return [
        'guid' => (string)Uuid::generate(4),
        'car' => $faker->unique()->word,
        'width' => (string)rand(10,99),
        'height' => (string)rand(10,99),
        'length' => (string)rand(10,99),
        'capacity' => (string)rand(10,99),
        'volume' => (string)rand(10,99),
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now'),
    ];
});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Product::class, function (Faker\Generator $faker) {

});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\CarRoute::class, function (Faker\Generator $faker) {

});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\RouteLog::class, function (Faker\Generator $faker) {

});


/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Delivery::class, function (Faker\Generator $faker) {

});

<?php

use Webpatser\Uuid\Uuid;
// LaravelArdent\Ardent:591 row for debud
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
$factory->define(App\UserType::class, function (Faker\Generator $faker) {
    return [
        'guid' => (string)Uuid::generate(4),
        'type' => $faker->unique()->word,
        'desc' => $faker->unique()->text
    ];
});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'guid' => (string)Uuid::generate(4),
        'type' =>  function () {
            return factory(App\UserType::class)->create()->type;
        },
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'fname' => $faker->firstName,
        'lname' => $faker->lastName,
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now'),
    ];

});

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\UserType::class, function (Faker\Generator $faker) {
    return [
        'guid' => (string)Uuid::generate(4),
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
    return [
        'guid' => (string)Uuid::generate(4),
        'sku' => $faker->unique()->word,
        'name' => $faker->unique()->word,
        'width' => (string)rand(10,99),
        'height' => (string)rand(10,99),
        'length' => (string)rand(10,99),
        'volume' => (string)rand(10,99),
        'weight' => (string)rand(10,99),
        'image' => null,
        'created_at' => $faker->dateTime('now'),
        'updated_at' => $faker->dateTime('now'),
    ];
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

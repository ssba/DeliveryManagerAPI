<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('user_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'root',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('user_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'manager',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('user_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'driver',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

    }
}





<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class RouteLogTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('route_log_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'InfoReceived',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('route_log_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'InTransit',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('route_log_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'OutForDelivery',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('route_log_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'FailedAttempt',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('route_log_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'Delivered',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('route_log_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'Exception',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('route_log_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'Expired',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('route_log_types')->insert([
            'guid' => $faker->uuid(),
            'type' => 'Pending',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}





<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('users')->insert([
            'guid' => '1678733c-cf81-4aa9-aac7-ecda4d52f62b',
            'type' => 'root',
            'email' => 'root@example.com',
            'password' => bcrypt('1'),
            'fname' => $faker->firstName(),
            'lname' => $faker->lastName(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'guid' => '8fae8f7a-884d-43f2-949f-87945cf984a1',
            'type' => 'manager',
            'email' => 'manager1@example.com',
            'password' => bcrypt('1'),
            'fname' => $faker->firstName(),
            'lname' => $faker->lastName(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'guid' => 'a09e6918-40e5-4693-8e60-f744ce28ba46',
            'type' => 'manager',
            'email' => 'manager2@example.com',
            'password' => bcrypt('1'),
            'fname' => $faker->firstName(),
            'lname' => $faker->lastName(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'guid' => '6e0f4e6a-51d1-4c03-97ee-c4e208d53360',
            'type' => 'driver',
            'email' => 'driver1@example.com',
            'password' => bcrypt('1'),
            'fname' => $faker->firstName(),
            'lname' => $faker->lastName(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'guid' => '73e9276b-284e-4ffe-a9df-6a682af527ce',
            'type' => 'driver',
            'email' => 'driver2@example.com',
            'password' => bcrypt('1'),
            'fname' => $faker->firstName(),
            'lname' => $faker->lastName(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('users')->insert([
            'guid' => 'f8ea1634-589d-4ccf-929f-0690eac935df',
            'type' => 'driver',
            'email' => 'driver3@example.com',
            'password' => bcrypt('1'),
            'fname' => $faker->firstName(),
            'lname' => $faker->lastName(),
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}





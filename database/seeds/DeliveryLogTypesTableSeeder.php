<?php

use Illuminate\Database\Seeder;

class DeliveryLogTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('delivery_log_types')->insert([
            'type' => 'InfoReceived',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('delivery_log_types')->insert([
            'type' => 'InTransit',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('delivery_log_types')->insert([
            'type' => 'OutForDelivery',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('delivery_log_types')->insert([
            'type' => 'FailedAttempt',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('delivery_log_types')->insert([
            'type' => 'Delivered',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('delivery_log_types')->insert([
            'type' => 'Exception',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('delivery_log_types')->insert([
            'type' => 'Expired',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('delivery_log_types')->insert([
            'type' => 'Pending',
            'desc' => '',
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

    }
}





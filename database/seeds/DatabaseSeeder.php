<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserTypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CarsTableSeeder::class);
        $this->call(ProductsTableSeeder::class);
        $this->call(CarRoutesTableSeeder::class);
        $this->call(DeliveryLogTypesTableSeeder::class);
        $this->call(DeliveriesTableSeeder::class);
        $this->call(DeliveryLogsTableSeeder::class);
    }
}

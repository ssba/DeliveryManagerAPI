<?php

use Illuminate\Database\Seeder;

class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('cars')->insert([
            'guid' => '04a19620-2fbf-4047-a13a-cc5af0bbf22c',
            'car' => 'GAZelle 3302 (RUS) N1',
            'width' => 9.8,
            'height' => 7.5,
            'length' => 6.2,
            'capacity' => 3307,
            'volume' => 413.2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('cars')->insert([
            'guid' => '81567399-f358-4c76-b738-3bedbdd717bc',
            'car' => 'GAZelle 3302 (RUS) N2',
            'width' => 9.8,
            'height' => 7.5,
            'length' => 6.2,
            'capacity' => 3307,
            'volume' => 413.2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('cars')->insert([
            'guid' => 'a8180a0c-a3c9-4734-afda-841929cf2035',
            'car' => 'GAZelle 3302 (RUS) N3',
            'width' => 9.8,
            'height' => 7.5,
            'length' => 6.2,
            'capacity' => 3307,
            'volume' => 413.2,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('cars')->insert([
            'guid' => '5d177260-d7e3-41b9-a86f-caf70eb8e29a',
            'car' => 'GAZelle 330202 (RUS) N1',
            'width' => 13.78,
            'height' => 7.5,
            'length' => 6.2,
            'capacity' => 3307,
            'volume' => 646.3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('cars')->insert([
            'guid' => 'b8b38b07-b374-49c7-94f9-c08418f9cc5b',
            'car' => 'GAZelle 330202 (RUS) N2',
            'width' => 13.78,
            'height' => 7.5,
            'length' => 6.2,
            'capacity' => 3307,
            'volume' => 646.3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('cars')->insert([
            'guid' => '1298f659-409d-4df4-bdeb-c3d89492d88c',
            'car' => 'GAZelle 330202 (RUS) N3',
            'width' => 13.78,
            'height' => 7.5,
            'length' => 6.2,
            'capacity' => 3307,
            'volume' => 646.3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);

        DB::table('cars')->insert([
            'guid' => 'e3db7f05-6530-47ce-a530-a90736b72642',
            'car' => 'GAZelle 330202 (RUS) N4',
            'width' => 13.78,
            'height' => 7.5,
            'length' => 6.2,
            'capacity' => 3307,
            'volume' => 646.3,
            'created_at' => date("Y-m-d H:i:s"),
            'updated_at' => date("Y-m-d H:i:s"),
        ]);
    }
}
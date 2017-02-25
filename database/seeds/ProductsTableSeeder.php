<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        $guids = [
            "300175d3-5558-4741-ad93-d9dcdd96b341",
            "93cb386a-6658-4356-b4a8-18efc12c448d",
            "cc7c58ad-5012-49d0-b746-efa11adc2f0e",
            "070374ba-c270-4d0e-8814-3388cb79a045",
            "32854463-8e71-4bff-a044-c3609e0fe494",
            "b9da8dfa-5b6a-42b8-a097-a1706b8b8190",
            "a854d68a-de95-456a-b714-b17c0e0f4060",
            "d32709c2-f7b7-4601-8a25-c3f480bef5cc",
            "01bb8f69-2331-445a-9590-4c913475eab8",
            "d94f4f14-8019-4626-a046-634b9d572318",
            "15c7863b-15d6-4027-ac95-6842e1d19858",
            "9510db0f-7802-4460-8ced-2517586ee192",
        ];


        foreach ($guids as $guid){

            DB::table('products')->insert([
                'guid' => $guid,
                'sku' => $faker->ean8,
                'name' => $faker->word,
                'width' => mt_rand (10, 50) / 10,
                'heigth' => mt_rand (10, 50) / 10,
                'length' => mt_rand (10, 50) / 10,
                'volume' => mt_rand (50, 100) / 10,
                'image' => null,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ]);

        }


    }
}
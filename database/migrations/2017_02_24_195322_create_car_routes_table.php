<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarRoutesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('car_routes', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->uuid('carGUID');
            $table->uuid('driver');
            $table->double('lat', 4, 20);
            $table->double('lng', 4, 20);
            $table->timestamps();
            $table->foreign('carGUID')->references('guid')->on('cars')->onDelete('cascade');
            $table->foreign('driver')->references('guid')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('car_routes');
    }
}

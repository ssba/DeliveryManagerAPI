<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->uuid('guid')->unique();
            $table->uuid('routeGUID');
            $table->uuid('productGUID');
            $table->integer('count');
            $table->timestamps();
            $table->foreign('routeGUID')->references('id')->on('car_routes')->onDelete('cascade');
            $table->foreign('productGUID')->references('guid')->on('products')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
}

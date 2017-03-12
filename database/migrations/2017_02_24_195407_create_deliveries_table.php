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
            $table->uuid('route');
            $table->uuid('product');
            $table->integer('count');
            $table->timestamps();
            $table->foreign('route')->references('guid')->on('car_routes')->onDelete('cascade');
            $table->foreign('product')->references('guid')->on('products')->onDelete('cascade');

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

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('route_logs', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->uuid('guid');
            $table->string('type');
            $table->uuid('routeGUID');
            $table->timestamps();
            $table->foreign('type')->references('type')->on('delivery_log_types')->onDelete('cascade');
            $table->foreign('routeGUID')->references('guid')->on('car_route')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_logs');
    }
}

<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cars', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->uuid('guid')->unique();
            $table->string('car');
            $table->double('width', 15, 8)->comment('ft');
            $table->double('heigth', 15, 8)->comment('ft');
            $table->double('length', 15, 8)->comment('ft');
            $table->double('capacity', 15, 8)->comment('lb');
            $table->double('volume', 15, 8)->comment('ft3');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cars');
    }
}

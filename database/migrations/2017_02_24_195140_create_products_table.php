<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {

            $table->engine = 'InnoDB';
            $table->uuid('guid')->unique();
            $table->string('sku');
            $table->string('name');
            $table->double('width', 15, 8)->comment('ft');
            $table->double('height', 15, 8)->comment('ft');
            $table->double('length', 15, 8)->comment('ft');
            $table->double('volume', 15, 8)->comment('ft3');
            $table->double('weight', 15, 8)->comment('ft');
            $table->string('image')->nullable();
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
        Schema::dropIfExists('products');
    }
}

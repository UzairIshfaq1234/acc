<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('supplier_id');
            $table->string('code');
            $table->string('name');
            $table->string('unit');
            $table->string('image')->nullable();
            $table->double('price',20,2)->nullable();
            $table->double('cost',20,2)->nullable();
            $table->integer('quantity')->nullable();
            $table->integer('quantity_alert')->nullable();
            $table->longText('description')->nullable();
            $table->integer('is_veg')->nullable();
            $table->integer('is_active')->nullable();
            $table->integer('loyalty_points')->nullable();
            $table->unsignedBigInteger('created_by');
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

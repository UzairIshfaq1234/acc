<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->dateTime('date')->nullable();
            $table->string('order_number');
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('table_no')->nullable();
            $table->double('service_charge',20,2)->nullable();
            $table->double('discount',20,2)->nullable();
            $table->double('subtotal',20,2)->nullable();
            $table->double('tax_percentage',15,2)->nullable();
            $table->double('tax_amount',15,2)->nullable();
            $table->double('total',20,2)->nullable();
            $table->integer('status')->default(0);
            $table->integer('order_type')->nullable();
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('table_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
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
        Schema::dropIfExists('orders');
    }
}

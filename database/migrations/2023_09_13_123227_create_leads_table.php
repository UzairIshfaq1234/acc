<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->longText('address')->nullable();
            $table->string('source');
            $table->string('type');
            $table->string('postcode')->nullable();
            $table->string('city')->nullable();
            $table->string('product_name')->nullable();
            $table->string('additional_field')->nullable();
            $table->string('message')->nullable();
            $table->integer('status')->default(0);
            $table->integer('appointment_status')->default(0);
            $table->integer('quotation_status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leads');
    }
};

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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_number');
            $table->date('created_date');
            $table->date('expiry_date');
            $table->unsignedBigInteger('lead_id');
            $table->string('address')->nullable();
            $table->string('stage');
            $table->double('sales_tax',20,2)->nullable();
            $table->double('discount',20,2)->nullable();
            $table->double('sub_total',20,2)->nullable();
            $table->double('discount_amount',20,2)->nullable();
            $table->double('tax_amount',20,2)->nullable();
            $table->double('total_amount',20,2)->nullable();
            $table->longText('description')->nullable();
            $table->longText('customer_note')->nullable();
            $table->integer('invoice_status')->default(0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};

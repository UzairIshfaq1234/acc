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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number');
            $table->date('date');
            $table->unsignedBigInteger('customer_id');
            $table->string('address');
            $table->string('type');
            $table->double('sales_tax',20,2)->nullable();
            $table->double('discount',20,2)->nullable();
            $table->double('sub_total',20,2)->nullable();
            $table->double('discount_amount',20,2)->nullable();
            $table->double('tax_amount',20,2)->nullable();
            $table->double('total_amount',20,2)->nullable();
            $table->longText('description')->nullable();
            $table->longText('customer_note')->nullable();
            $table->date('maintenance_date')->nullable();
            $table->Integer('first_invoice')->nullable();
            $table->date('first_due_date')->nullable();
            $table->Integer('first_invoice_amount')->nullable();
            $table->Integer('first_invoice_paid')->nullable();
            $table->Integer('second_invoice')->nullable();
            $table->date('second_due_date')->nullable();
            $table->Integer('second_invoice_amount')->nullable();
            $table->Integer('second_invoice_paid')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};

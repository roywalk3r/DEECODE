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
            $table->increments('id');
            $table->string('reference', 20);
            $table->date('date');
            $table->date('date_due')->nullable();
            $table->string('title', 25)->default('Invoice');
            $table->string('description');
            $table->string('status', 25)->default('Draft');
            $table->foreignId('bill_to_id')->nullable();
            $table->text('note');
            $table->text('terms');
            $table->string('currency', 10)->default('USD');
            $table->boolean('discount_type')->default(1);
            $table->decimal('subtotal', 25, 4)->default(0.0000);
            $table->decimal('global_discount', 25, 4)->default(0.0000);
            $table->decimal('shipping', 10, 2)->default(0.00);
            $table->decimal('total_discount', 25, 4)->default(0.0000);
            $table->decimal('total_tax', 25, 4)->default(0.0000);
            $table->decimal('total', 25, 4)->default(0.0000);
            $table->integer('count')->default(0);
            $table->decimal('total_due', 10, 2)->default(0.00);
            $table->date('payment_date')->nullable();
            $table->foreignId('estimate_id')->nullable();
            $table->integer('recurring_id')->nullable();
            $table->boolean('double_currency')->default(0);
            $table->decimal('rate', 25, 4)->default(0.0000);
            $table->foreignId('user_id')->nullable();
            $table->string('custom_field1');
            $table->string('custom_field2');
            $table->string('custom_field3');
            $table->string('custom_field4');
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

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
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('invoice_id')->nullable();
            $table->foreignId('item_id')->nullable();
            $table->string('name');
            $table->string('description')->nullable();
            $table->decimal('quantity', 25, 4)->default(0.0000);
            $table->decimal('unit_price', 25, 4)->default(0.0000);
            $table->boolean('tax_type')->default(1);
            $table->decimal('tax', 25, 4)->default(0.0000);
            $table->boolean('discount_type')->default(1);
            $table->decimal('discount', 25, 4)->default(0.0000);
            $table->decimal('total', 25, 4)->default(0.0000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};

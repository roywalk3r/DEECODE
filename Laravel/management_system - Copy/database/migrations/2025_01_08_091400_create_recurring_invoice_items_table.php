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
        Schema::create('recurring_invoice_items', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('invoice_id')->nullable();
            $table->integer('recurring_id');
            $table->date('date');
            $table->boolean('skip')->default(0);
            $table->foreignId('recurring_invoice_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recurring_invoice_items');
    }
};

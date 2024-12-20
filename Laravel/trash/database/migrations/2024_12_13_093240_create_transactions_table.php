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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('payment_id')->constrained()->onDelete('cascade'); // Foreign Key to Payments table
            $table->json('gateway_response')->nullable(); // Gateway response stored as JSON
            $table->enum('status', ['processing', 'success', 'error'])->default('processing'); // Transaction status
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // Soft delete feature for historical data storage
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

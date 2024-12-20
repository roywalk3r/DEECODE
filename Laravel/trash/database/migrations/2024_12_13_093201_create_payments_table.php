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
        Schema::create('payments', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->foreignId('student_id')->constrained()->onDelete('cascade'); // Foreign Key to Students table
            $table->foreignId('fee_structure_id')->constrained()->onDelete('cascade'); // Foreign Key to Fee Structures table
            $table->decimal('amount_paid', 10, 2); // Amount paid by the user
            $table->string('payment_method')->default('card'); // Payment method (e.g., card, bank transfer)
            $table->string('transaction_id')->nullable(); // Transaction reference from the payment gateway
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Payment status
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // Soft delete functionality for historical records
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};

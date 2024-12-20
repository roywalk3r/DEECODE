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
        Schema::create('fee_structures', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('class'); // Class/grade the fee applies to
            $table->string('term')->nullable(); // Optional: Term or semester
            $table->decimal('amount', 10, 2); // Fee amount
            $table->string('description')->nullable(); // Optional description of the fee
            $table->timestamps(); // created_at and updated_at

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fee_structures');
    }
};

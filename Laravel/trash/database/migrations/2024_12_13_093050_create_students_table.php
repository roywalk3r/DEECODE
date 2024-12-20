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
        Schema::create('students', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('name'); // Student's full name
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign Key to Users table
            $table->string('class'); // Student's class/grade
            $table->string('department')->nullable(); // Optional field for department
            $table->string('admission_no')->unique(); // Unique student admission number
            $table->timestamps(); // created_at and updated_at
            $table->softDeletes(); // Soft delete functionality (available in Laravel 8.32+)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

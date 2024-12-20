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
                $table->unsignedBigInteger('user_id'); // Foreign Key to Users table
                $table->unsignedBigInteger('student_class_id')->nullable(); // Foreign Key to StudentClasses
                $table->string('admission_no')->unique(); // Unique student admission number
                $table->string('department')->nullable(); // Optional field for department
                $table->timestamps(); // created_at and updated_at
                $table->softDeletes(); // Enable soft deletes

                // Foreign Key Constraints
                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('student_class_id')->references('id')->on('student_classes')->onDelete('set null');
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

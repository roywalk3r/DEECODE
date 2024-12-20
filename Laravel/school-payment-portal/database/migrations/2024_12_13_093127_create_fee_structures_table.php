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
            $table->id();
            $table->unsignedBigInteger('term');
            $table->decimal('amount', 8, 2);
            $table->string('description');
            $table->unsignedBigInteger('student_class_id'); // Foreign key to StudentClass
            $table->timestamps();

            $table->foreign('student_class_id')->references('id')->on('student_classes')->onDelete('cascade');
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

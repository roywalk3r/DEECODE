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
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->foreignId('biller_id');
            $table->integer('progress');
            $table->string('billing_type');
            $table->decimal('rate', 25, 4)->default(0.0000);
            $table->string('currency', 10)->default('USD');
            $table->integer('estimated_hours')->default(0);
            $table->string('status')->default('progress');
            $table->date('date');
            $table->date('date_due')->nullable();
            $table->text('members');
            $table->text('description');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};

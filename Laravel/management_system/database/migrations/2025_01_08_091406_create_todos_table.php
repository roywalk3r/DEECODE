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
        Schema::create('todos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('subject');
            $table->integer('priority');
            $table->integer('complete');
            $table->text('description');
            $table->date('date');
            $table->date('date_due')->nullable();
            $table->foreignId('user_id')->nullable();
            $table->text('attachments');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('todos');
    }
};

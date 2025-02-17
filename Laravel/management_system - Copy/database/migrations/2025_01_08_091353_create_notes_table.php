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
        Schema::create('notes', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('user_id');
            $table->string('title');
            $table->text('body');
            $table->enum('priority', ["high","medium","low"]);
            $table->enum('status', ["start","pending","completed"])->default('pending');
            $table->dateTime('created_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};

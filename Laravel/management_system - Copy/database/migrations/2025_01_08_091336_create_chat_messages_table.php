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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->increments('id');
            $table->text('content');
            $table->unsignedInteger('from');
            $table->unsignedInteger('to');
            $table->integer('read')->default(0);
            $table->dateTime('date');
            $table->dateTime('date_read')->nullable();
            $table->integer('offline')->default(0);
            $table->foreignId('user_id');
            $table->foreignId('from_id');
            $table->foreignId('to_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};

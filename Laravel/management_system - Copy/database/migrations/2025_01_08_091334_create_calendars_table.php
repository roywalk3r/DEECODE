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
        Schema::create('calendars', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->integer('repeat_type');
            $table->string('repeat_days', 50)->nullable();
            $table->boolean('no_end')->nullable();
            $table->string('emails');
            $table->string('subject');
            $table->text('additional_content');
            $table->text('attachments');
            $table->date('last_send')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calendars');
    }
};

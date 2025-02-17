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
        Schema::create('project_tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('project_id');
            $table->string('subject');
            $table->decimal('hour_rate', 25, 4);
            $table->date('date');
            $table->date('date_due')->nullable();
            $table->integer('priority');
            $table->text('description');
            $table->text('attachments');
            $table->string('status');
            $table->foreignId('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('project_tasks');
    }
};

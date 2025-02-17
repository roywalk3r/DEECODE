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
        Schema::create('files', function (Blueprint $table) {
            $table->increments('id');
            $table->string('realpath');
            $table->string('link');
            $table->string('filename');
            $table->string('extension', 10);
            $table->string('type');
            $table->string('folder');
            $table->dateTime('date_upload');
            $table->string('thumb');
            $table->decimal('size', 25, 4);
            $table->foreignId('user_id');
            $table->boolean('trash')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};

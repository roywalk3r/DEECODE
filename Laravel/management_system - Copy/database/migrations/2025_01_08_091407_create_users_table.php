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
        Schema::create('users', function (Blueprint $table) {
            $table->unsignedInteger('id');
            $table->string('ip_address', 45);
            $table->string('username', 100)->nullable();
            $table->string('password');
            $table->string('salt')->nullable();
            $table->string('email', 100);
            $table->string('activation_code', 40)->nullable();
            $table->string('forgotten_password_code', 40)->nullable();
            $table->unsignedInteger('forgotten_password_time')->nullable();
            $table->string('remember_code', 40)->nullable();
            $table->unsignedInteger('created_on');
            $table->unsignedInteger('last_login')->nullable();
            $table->unsignedTinyInteger('active')->nullable();
            $table->string('first_name', 50)->nullable();
            $table->string('last_name', 50)->nullable();
            $table->string('company', 100)->nullable();
            $table->string('phone', 20)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

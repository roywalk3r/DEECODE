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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->string('phone', 30)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('website')->default('');
            $table->text('address')->nullable();
            $table->text('address2');
            $table->string('city', 55);
            $table->string('state', 55);
            $table->string('postal_code', 8);
            $table->string('country', 55);
            $table->string('company');
            $table->string('vat_number')->default('');
            $table->unsignedInteger('user_id')->nullable();
            $table->string('custom_field1')->nullable();
            $table->string('custom_field2')->nullable();
            $table->string('custom_field3')->nullable();
            $table->string('custom_field4')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
